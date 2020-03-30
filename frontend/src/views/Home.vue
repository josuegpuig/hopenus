<template>
  <div>
    <img alt="Vue logo" src="../assets/logo.png" />
    <p>{{ $t('message') }}</p>
    <FacebookLogin />
    <b-nav tabs>
      <b-nav-item><router-link :to="{ name: 'Home' }" class="card-link">News</router-link></b-nav-item>
      <b-nav-item><router-link to="posts" class="card-link">Posts</router-link></b-nav-item>
    </b-nav>
    <router-view></router-view>
  </div>
</template>

<script>
import FacebookLogin from "../components/FacebookLogin";

export default {
  name: "Home",
  components: {
    FacebookLogin,
  }
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
