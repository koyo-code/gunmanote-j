import "../scss/main.scss";
import { Start } from "./start";

window.debug = enableDebugMode(false);

function enableDebugMode(debug) {
  return debug && import.meta.env.DEV;
}

window.addEventListener("DOMContentLoaded", () => new Start());
