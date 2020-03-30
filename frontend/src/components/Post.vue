<template>
  <section>
    <Loading v-if="!loaded" />
    <b-card v-for="(post,i) in posts" :key="i">
      <div>
        <b-avatar variant="info" :src="post.user_information.picture"></b-avatar>
        {{ post.user_information.first_name }} {{ post.user_information.last_name }}
      </div>
      
      <b-card-text>{{ post.body }}</b-card-text>

      <router-link :to="{ name: 'Post', params: {id: post.id} }" class="card-link">{{ post.comments_count }} Comentarios</router-link>
    </b-card>
    <router-link v-if="showMore != false" :to="{ name: 'Feed' }" class="card-link">Ver más</router-link>
  </section>
</template>

<script>
import Loading from '../components/Loading'
export default {
  props: ['category','showMore','new_posts'],
  components: {
    Loading
  },
  data() {
    return {
      posts: [],
      mainProps: { width: 40, height: 40, class: 'm1' },
      loaded: false,
    };
  },
  watch: {
    'category': function() {
      this.consultCategory(this.category);
    },
    'new_posts': function() {
      this.addPost();
    }
  },
  methods: {
    consultCategory(category) {
      this.$axios
      .post("http://localhost:8000/api/post/post_category", {
        main_category: category
      })
      .then(res => {
        this.posts = [...res.data.posts];
        this.loaded = true;
      });
    },
    addPost() {
      this.posts = [...this.new_posts, ...this.posts];
    }
  },
  beforeMount() {
    let category = this.category ? this.category : 1
    this.consultCategory(category);
  }
};
</script>