import Swiper from "swiper";
import { Autoplay, Navigation, Thumbs } from "swiper/modules";

export default async function () {
  
const thumbPrevButton = document.querySelector(".swiper-button-prev--1");
const thumbNextButton = document.querySelector(".swiper-button-next--1");

const spotSlider = new Swiper(".thumbnail", {
  slidesPerView: 5,
  spaceBetween: 6,
  watchSlidesProgress: true,
  slideToClickedSlide: true,
  breakpoints: {
    768: { spaceBetween: 12 },
  },
});

const spotThumbnail = new Swiper(".slider", {
  modules: [Thumbs, Navigation],
  loop: true,
  slidesPerView: 1,
  centeredSlides: true,
  navigation: {
    nextEl: thumbNextButton,
    prevEl: thumbPrevButton,
  },

  thumbs: {
    swiper: spotSlider,
    autoScrollOffset: 0,
  },
});

  const seasonSlider = new Swiper(".seasonSlider .swiper", {
    modules: [Navigation, Autoplay],
    loop: true,
    allowTouchMove: true,
    slidesPerView: 1,
    spaceBetween: 15,
    centeredSlides: true,
    autoplay: {
      delay: 3000,
    },
    breakpoints: {
      620: {
        spaceBetween: 20,
        slidesPerView: 1.5,
      },
      1180: {
        slidesPerView: 2.1,
      },
    },
    navigation: {
      nextEl: ".swiper-button-next--2",
      prevEl: ".swiper-button-prev--2",
    },
  });
}
