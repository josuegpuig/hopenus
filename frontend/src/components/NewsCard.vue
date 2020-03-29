<template>
  <b-card-group>
    <b-card
      v-for="(article,i) in news" :key="i"
      :title=article.title
      :img-src=article.urlToImage
      img-alt="Image"
      img-top
      img-height=180
      img-width=319
      tag="article"
      style="min-width: 20rem;max-width: 20rem;"
      class="mb-2"
    >
      <b-card-text>{{ article.description }}</b-card-text>

      <b-button :href=article.url variant="primary">Ir a la noticia</b-button>
    </b-card>
  </b-card-group>
</template>

<script>
export default {
  data () {
    return { 
      news: []
    }
  },
  beforeMount() {
    // this.$axios
    //   .get(
    //     "https://newsapi.org/v2/top-headlines?country=mx&q=coronavirus&pageSize=100&apiKey=7531deb4465d4cb4a8a5a0d4c63f4269"
    //   )
    //   .then(res => {
    //     console.log(res.data);
    //     this.news = [...res.data.articles];
    //     this.news.sort((a,b) => new Date(a.publishedAt) - new Date(b.publishedAt))
    //   });
  }
};
</script>