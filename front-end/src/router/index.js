import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/users/Login.vue";
import Register from "../views/users/Register.vue";
import AllBooks from "../views/books/AllBooks.vue";
import AddBook from "../views/books/AddBook.vue";
import EditBook from "../views/books/EditBook.vue";
import ListUser from "../views/users/ListUser.vue";
import EditProfile from "../views/users/EditProfile.vue";

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
  {
    name:'ListUser',
    path:'/list-users',
    component:ListUser
  },
  {
    name:'EditProfile',
    path:'/edit-profile/:id',
    component:EditProfile,
    meta: { authOnly: true }
  }
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
