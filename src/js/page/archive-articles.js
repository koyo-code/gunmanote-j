
export default async function () {
  function setSearch() {
    const formSearchButtons = document.querySelectorAll(".form__cat-button");
    const formSearchModals = document.querySelectorAll(".form__modal");
    const formSubmitButton = document.querySelector(".form__submit");
    const formResetButton = document.querySelector(".form__reset");
    const formSearchWindow = document.querySelector(".form__window");
    const formWindowCross = document.querySelector(".form__cross");
    const overlay = document.querySelector(".form__overlay");

    formSearchButtons.forEach((_, index) => {
      formSearchButtons[index].addEventListener("click", () => {
        overlay.classList.add("is-active");
        formSearchModals[index].classList.add("is-active");
      });
    });
    overlay.addEventListener("click", () => {
      overlay.classList.remove("is-active");
      formSearchButtons.forEach((_, index) => {
        formSearchModals[index].classList.remove("is-active");
      });
    });

    formSearchModals.forEach((modal) => {
      const closeButton = modal.querySelector(".form__modal-close");
      closeButton.addEventListener("click", () => {
        overlay.classList.remove("is-active");
        modal.classList.remove("is-active");
      });
    });
    formWindowCross.addEventListener("click", () => {
      formSearchWindow.value = "";
    });

    const wraps = document.querySelectorAll(".form__cat-wrap");
    wraps.forEach((wrap) => {
      const parentInput = wrap.querySelector(".form__cat-parenet-input");
      parentInput.addEventListener("change", () => parentChange(wrap));
      const childs = wrap.querySelectorAll(".form__item-child");
      childs.forEach((child) => {
        child.addEventListener("change", () => childChange(wrap));
      });
    });

    formResetButton.addEventListener("click", () => allReset());
    formSubmitButton.addEventListener("click", () => submit());

    function parentChange(wrap) {
      const parentInput = wrap.querySelector(".form__cat-parenet-input");
      const childs = wrap.querySelectorAll(".form__item-child");
      childs.forEach((child) => {
        if (parentInput.checked) {
          child.checked = true;
        } else {
          child.checked = false;
        }
      });
    }

    function childChange(wrap) {
      const parentInput = wrap.querySelector(".form__cat-parenet-input");
      const childs = [...wrap.querySelectorAll(".form__item-child")];

      const checkTrue = childs.filter((child) => {
        return child.checked;
      });

      parentInput.checked = checkTrue.length === childs.length ? true : false;
    }
    function allReset() {
      const allInputChecks = document.querySelectorAll(
        "input[type='checkbox']"
      );

      const inputWindow = document.querySelector("input[type='text']");

      formResetButton.textContent = "リセット完了";
      setTimeout(() => {
        formResetButton.textContent = "条件をリセット";
      }, 600);

      allInputChecks.forEach((check) => {
        check.checked = false;
      });

      inputWindow.value = "";
    }
    function submit() {
      let checkInputs = [];
      formSearchModals.forEach((modal) => {
        const modalCheckInputs = [...modal.querySelectorAll("input")]
          .filter((input) => {
            return input.checked;
          })
          .map((input) => {
            return input.name;
          });

        checkInputs.push(modalCheckInputs);
      });

      const searchQ = formSearchWindow.value;

      checkInputs = checkInputs.map((input) => {
        return input.join(",");
      });

      window.location.href =`/articles/?contents=${checkInputs[0]}&s=${searchQ}`

    }
  }

  setSearch();
}
