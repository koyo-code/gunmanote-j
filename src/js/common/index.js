
import gsap from "gsap";
import ScrollToPlugin from "gsap/ScrollToPlugin";

export default function () {
  gsap.registerPlugin(ScrollToPlugin);
  function setMenu() {
    const menu = document.querySelector(".menu");
    window.addEventListener("scroll", () => {
      if (100 <= window.scrollY) {
        menu.classList.add("is-active");
      } else {
        menu.classList.remove("is-active");
      }
    });

    const toc = document.querySelector(".toc");

    if (toc) {
      const tocButton = document.querySelector(".toc__button");
      const tocMenu = document.querySelector(".toc-menu");

      tocButton.addEventListener("click", () => {
        tocButton.classList.toggle("is-active");
        tocMenu.classList.toggle("is-active");
      });

      const tocs = document.querySelector(".toc-menu__list");
      const h2List = document.querySelectorAll("h2");
      if (h2List.length <= 2) {
        toc.remove();
        return;
      }

      h2List.forEach((h2Item, index) => {
        h2Item.setAttribute("id", "note" + index);
        const li = document.createElement("li");
        const a = document.createElement("a");
        li.setAttribute("class", "toc-menu__item");
        a.setAttribute("class", "toc-menu__item-link");
        a.setAttribute("href", "#" + h2Item.id);
        a.textContent = h2Item.textContent;
        a.dataset["link"] = h2Item.id;
        li.appendChild(a);
        tocs.appendChild(li);
      });

      document.querySelectorAll(".toc-menu__item-link").forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          tocButton.classList.remove("is-active");
          tocMenu.classList.remove("is-active");
        });
      });
    }
  }

  function setCopyButton() {
    const copyButton = document.querySelector(".share__link--copy");
    if (copyButton) {
      const copyIcon = copyButton.querySelector(".share__img");
      copyButton.addEventListener("click", () => {
        const url = window.location.href;
        if (navigator.clipboard) {
          navigator.clipboard
            .writeText(url)
            .then(() => {
              copyIcon.setAttribute("src", imgs + "/common/check.svg");
              setTimeout(() => {
                copyIcon.setAttribute("src", imgs + "/common/copy.svg");
              }, 1000);
            })
            .catch((err) => {
              console.error("Failed to copy URL: ", err);
            });
        }
      });
    }
  }

  function headerHandler() {
    const hamburger = document.querySelector(".hamburger");
    const hamburgerNav = document.querySelector(".hamburger-nav");
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("is-active");
      hamburgerNav.classList.toggle("is-active");
    });
  }


  function getCurrentDir() {
  const currentUrl = getCurrentUrl();
  gNavLinks.forEach((gNavLink) => {
    if (gNavLink.href.includes(getFormattedSection(currentUrl))) {
      gNavLink.classList.add("is-active");
    } else {
      gNavLink.classList.remove("is-active");
    }
  });
}

function getCurrentUrl() {
  const protocol = window.location.protocol; // プロトコル（http: または https:）
  const host = window.location.host; // ホスト名（例: 192.168.128.115:1000）
  const path = window.location.pathname; // パス（例: /contact/detail/）
  return `${protocol}//${host}${path}`; // フルURLを組み立て
}
// 第二階層のディレクトリ名を取得する関数
function getFormattedSection(url) {
  // URLを処理してパス部分を抽出し、スラッシュで分割
  const path = new URL(url).pathname;
  const segments = path.split("/").filter(Boolean); // 空の要素を除外

  // 最初のセグメントの先頭を大文字に変換
  return segments[0] ? segments[0].charAt(0) + segments[0].slice(1) : "---";
}




const gNavLinks = document.querySelectorAll(".g-nav__link");

  getCurrentDir();
  setMenu();
  setCopyButton();
  headerHandler();
}
