import path, { resolve } from "node:path";
import dotenv from "dotenv";
import { glob } from "glob";
import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";
import vitePluginReplaceCss from "vite-plugin-replace-css";
import { viteStaticCopy } from "vite-plugin-static-copy";
import VitePluginWebpAndPath from "vite-plugin-webp-and-path";

const env = dotenv.config().parsed;

const assetsPort = Number(env.DEV_PORT) + 1;

const base = "./";
const srcDir = "./src";
const distDir = path.resolve(__dirname, "dist");

const dirName = __dirname.replaceAll("\\", "/");

const targetString = `http://${env.ADDRESS}:${assetsPort}/`;
const replaceString = `/wp/wp-content/themes/${env.THEME_NAME}/`;

let copyPHPList = glob.sync(`${srcDir}/**/*.php`);

copyPHPList = copyPHPList.map((copyPHPItem) => {
  return copyPHPItem.replaceAll("\\", "/");
});

const copyTargets = [];
function transformPaths(input) {
  return input
    .trim()
    .split("\n")
    .map((line) => {
      const parts = line.split("/");
      if (parts[parts.length - 1] === parts[parts.length - 2]) {
        return `./${parts.slice(1, parts.length - 2).join("/")}/`;
      } else {
        return `./${parts.slice(1, parts.length - 1).join("/")}/`;
      }
    })
    .join("\n");
}
copyPHPList.forEach((copyItem) => {
  const dest = transformPaths(`./${copyItem.split("src/")[1]}`);
  copyTargets.push({
    src: `${dirName}/${copyItem}`,
    dest,
  });
});
copyTargets.push({
  src: `${dirName}/src/style.css`,
  dest: ".",
});

export default defineConfig({
  root: srcDir,
  base,
  publicDir: "../public",
  css: {
    devSourcemap: true,
    preprocessorOptions: {
      scss: {
        additionalData: `@use "@/scss/common/information.scss" with (
          $imgs: "http://${env.ADDRESS}:${assetsPort}/imgs"
        );`,
      },
    },
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, srcDir),
    },
  },
  build: {
    outDir: distDir,
    emptyOutDir: false,
    manifest: true,
    sourcemap: false,
    target: "es2018",
    minify: true,
    rollupOptions: {
      external: ["js/main.js"],
      output: {
        assetFileNames: (assetInfo) => {
          const extType = assetInfo.name.split(".")[1];
          return `${extType}/[name][extname]`;
        },
        chunkFileNames: "js/[name].js",
        entryFileNames: "js/[name].js",
        manualChunks(id) {
          if (id.includes("node_modules")) {
            return "vendor";
          }
        },
      },
      input: {
        main: resolve(srcDir, "js", "main.js"),
      },
    },
  },
  server: {
    cors: true,
    port: assetsPort,
    open: `http://${env.ADDRESS}:${env.DEV_PORT}/`,
    https: false,
    host: true,
    hmr: true,
  },
  plugins: [
    liveReload(`${dirName}/src/**/*.php`),
    vitePluginReplaceCss(targetString, replaceString, distDir),
    VitePluginWebpAndPath({
      targetDir: "./dist/",
      imgExtensions: "jpg,png",
      textExtensions: "html,css,php",
      quality: 70, //
    }),
    viteStaticCopy({
      targets: copyTargets,
    }),
  ],
});
