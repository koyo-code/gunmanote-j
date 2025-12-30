import gsap from "gsap";
import Common from "./common";
import loadPageFile from "./loadPage";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
class Start {
  constructor() {
    gsap.registerPlugin(ScrollToPlugin);
    this.init();
    Common();
  }
  async init() {
    await loadPageFile();
    this.setLinkSmooth();
  }
  setLinkSmooth(){
  const headerHeight = document.querySelector(".header").offsetHeight;
  const linkEls = document.querySelectorAll("[data-link]");
  linkEls.forEach((linkEl) => {
    linkEl.addEventListener("click", () => {
    const id = linkEl.dataset["link"];
    const target = document.getElementById(id);
      gsap.to(window, {
        duration: 1,
        ease: "power3.inOut",
        scrollTo: { y: target, offsetY: headerHeight + 50 },
      });
    });
  });
}
}

export { Start };
