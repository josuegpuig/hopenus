<template>
  <div>
    <img alt="Vue logo" src="../assets/logo.png">
    <p>{{ $t('message') }}</p>
    <FacebookLogin />
    <NewsCard />
    <Post />
  </div>
</template>

<script>
import FacebookLogin from '../components/FacebookLogin'
import NewsCard from '../components/NewsCard'
import Post from '../components/Post'

export default {
  name: 'Home',
  components: {
    FacebookLogin,
    NewsCard,
    Post
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
