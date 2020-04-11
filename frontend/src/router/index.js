import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import NewsCard from "../components/NewsCard"; 

//import Post from '../components/Post';

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    children: [
      { path: '', name: 'HomeNews', component: NewsCard },
      { path: 'posts', component: () => import(/* webpackChunkName: "posts" */ '../components/Post.vue') },
    ]
  },
  {
    path: '/post/:id',
    name: 'Post',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "postdetails" */ '../views/PostDetails.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "login" */ '../views/Login.vue')
  },
  {
    path: '/feed',
    name: 'Feed',
    component: () => import(/* webpackChunkName: "feed" */ '../views/Feed.vue'),
  },
  {
    path: '/search',
    name: 'Search',
    component: () => import(/* webpackChunkName: "search" */ '../views/Search.vue'),
  },
  {
    path: '/map',
    name: 'Map',
    component: () => import(/* webpackChunkName: "map" */ '../views/Map.vue'),
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
