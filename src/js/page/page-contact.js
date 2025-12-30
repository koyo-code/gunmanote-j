export default async function () {
  class Contact {
    constructor() {
      this.emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      this.formItems = [
        ...document.querySelectorAll(".form-item__input,.form-item__textarea"),
      ];
      this.check = document.querySelector(".contact-form__check-box");
      this.submit = document.querySelector(".contact-form__button");
      this.wrapper = document.querySelector(".sub-layout__left");

      this.init();
    }

    init() {
      this.check.addEventListener("change", this.checkConfirm.bind(this));
      this.submit.addEventListener("click", this.go.bind(this));
      this.formItems.forEach((formItem) => {
        formItem.addEventListener("change", () => this.valid(formItem));
      });
    }

    addValid(item, text) {
      item.nextElementSibling.classList.add("is-active");
      item.nextElementSibling.innerText = text;
    }
    removeBlankValid(item) {
      item.nextElementSibling.classList.remove("is-active");
      item.nextElementSibling.innerText = "";
    }

    checkMail(formItem) {
      if (!this.emailPattern.test(formItem.value)) {
        this.addValid(formItem, "正しいメールアドレスを入力してください");
        return true;
      } else {
        this.removeBlankValid(formItem);
        return false;
      }
    }

    checkConfirm() {
      if (this.check.checked) {
        this.submit.classList.add("is-active");
      } else {
        this.submit.classList.remove("is-active");
      }
    }

    valid(formItem) {
      let isNo = false;

      if (!formItem.value) {
        this.addValid(formItem, "入力してください");
        isNo = true;
      } else if (formItem.type === "email") {
        isNo = this.checkMail(formItem);
      } else {
        this.removeBlankValid(formItem);
      }
      return isNo;
    }

    go() {
      if (!this.check.checked) return;

      const sendOks = this.formItems.filter((formItem) => {
        return this.valid(formItem);
      });

      if (sendOks.length !== 0) return;

      this.send();
    }

    send() {
      const xhr = new XMLHttpRequest();
      const fd = new FormData();

      this.formItems.forEach((formItem) => {
        fd.append(formItem.name, formItem.value);
      });

      xhr.open("POST", "https://ssgform.com/s/hZLIc3P0HPUs", true);
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.send(fd);
      xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
          this.wrapper.innerHTML = `
              <div class="editor">
                  <div class="editor__inner">
                      <h2>お問い合わせありがとうございました</h2>
                      <p>
                      お送り頂きました内容を確認の上、数日以内に折り返しご連絡させて頂きます。<br />
                      また、ご記入頂いたメールアドレスへ、自動返信の確認メールをお送りしております。<br />
                      しばらく経ってもメールが届かない場合は、入力頂いたメールアドレスが間違っているか、迷惑メールフォルダに振り分けられている可能性がございます。
                      </p>
                  </div>
              </div>
              <a href="/" class="btn btn--left btn--reverse"><p class="btn__text">トップページに戻る</p></a>
              `;
          const headerHeight = document.querySelector(".header").offsetHeight;
          gsap.to(window, {
            duration: 0,
            scrollTo: { y: "#sub-layout", offsetY: headerHeight + 50 },
          });
        }
      });
    }
  }

  new Contact();
}
