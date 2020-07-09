import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import AllBooks from "../views/AllBooks.vue";
import AddBook from "../views/AddBook.vue";
import EditBook from "../views/EditBook.vue";


Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "AllBooks",
    component: AllBooks
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { guestOnly: true }
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: { guestOnly: true }
  },
  {
    path: "/dashboard",
    name: "AllBooks",
    component: AllBooks
  },
  {
    name:'Add',
    path:'/add',
    component:AddBook,
    meta: { authOnly: true }
  },
  {
    name:'Edit',
    path:'/edit/:id',
    component:EditBook,
    meta: { authOnly: true }
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

function isLoggedIn() {
  return localStorage.getItem("auth");
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isLoggedIn()) {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guestOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isLoggedIn()) {
      next({
        path: "/dashboard",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else {
    next(); // make sure to always call next()!
  }
});

export default router;
