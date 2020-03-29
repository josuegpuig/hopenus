<template>
  <div id="app">
    <Navbar />
    <img alt="Vue logo" src="./assets/logo.png">
    <p>{{ $t('message') }}</p>
    <FacebookLogin />
    <NewsCard />
  </div>
</template>

<script>
import Navbar from './components/Navbar'
//import HelloWorld from './components/HelloWorld.vue'
import FacebookLogin from './components/FacebookLogin'
import NewsCard from './components/NewsCard'

export default {
  name: 'App',
  components: {
    FacebookLogin,
    Navbar,
    NewsCard
  }
}
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
