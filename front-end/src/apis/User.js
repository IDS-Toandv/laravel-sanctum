import Api from "./Api";
import Csrf from "./Csrf";

export default {
  async register(form) {
    await Csrf.getCookie();

    return Api.post("/register", form);
  },

  async login(form) {
    await Csrf.getCookie();

    return Api.post("/login", form);
  },

  async logout() {
    await Csrf.getCookie();
    const idToken = localStorage.getItem('idToken');
    const emailLogin = localStorage.getItem('email');
    localStorage.removeItem('idToken');
    localStorage.removeItem('email');
    return Api.post("/logout", {idToken:idToken, emailLogin:emailLogin});
  },

  auth() {
    return Api.get("/user");
  }
};
