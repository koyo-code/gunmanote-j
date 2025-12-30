import Swiper from "swiper";
import { Autoplay,  Navigation, EffectFade } from "swiper/modules";

export default async function () {

  const mvSlider = new Swiper(".mvSlider", {
    modules: [Autoplay,EffectFade],
    effect: 'fade',
    loop: true,
    allowTouchMove: true,
    speed: 800,
    slidesPerView: 1,
    autoplay: {
      delay: 4000,
    },
  });

  const seasonSlider = new Swiper(".seasonSlider", {
    modules: [Navigation, Autoplay],
    loop: true,
    allowTouchMove: true,
    slidesPerView: 1.1,
    centeredSlides: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    breakpoints: {
      501:{
            slidesPerView: 1.5,
      },
      768: {
      slidesPerView: 2.5,
      },
      1240: {
      slidesPerView: 3,
      },
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });


  class tabSwitch {
    constructor({ category = "season" }) {
      this.btnEls = document.querySelectorAll(`[data-tab-btn="${category}"]`);
      this.contentEls = document.querySelectorAll(
        `[data-tab-content="${category}"]`
      );
      this.toggleClass = "is-active";

      this.init();
    }
    init() {
      this.btnEls.forEach((btnEl, i) => {
        btnEl.addEventListener("click", this.main.bind(this, i));
      });
    }
    main(i, e) {
      e.preventDefault();
      e.stopPropagation();

      for (let _i = 0; _i < this.contentEls.length; _i++) {
        if (_i === i) {
          this.btnEls[i].classList.add(this.toggleClass);
          this.contentEls[i].classList.add(this.toggleClass);
        } else {
          this.btnEls[_i].classList.remove(this.toggleClass);
          this.contentEls[_i].classList.remove(this.toggleClass);
        }
      }
    }
  }

  new tabSwitch({ category: "search" });
}
