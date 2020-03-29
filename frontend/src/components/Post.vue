<template>
  <section>
    <b-card v-for="(post,i) in posts" :key="i">
      <div>
        <b-avatar variant="info" src="https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10220805271617620&height=200&width=200&ext=1588054727&hash=AeQIJ8fSR82bB9ab"></b-avatar>
        {{ post.user_information.first_name }} {{ post.user_information.last_name }}
      </div>
      
      <b-card-text>{{ post.body }}</b-card-text>

      <router-link :to="{ name: 'Post', params: {id: post.id} }" class="card-link">4 Comentarios</router-link>
    </b-card>
  </section>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      mainProps: { width: 40, height: 40, class: 'm1' }
    };
  },
  beforeMount() {
    this.$axios
      .post("http://localhost:8000/api/post/post_category", {
        main_category: 1
      })
      .then(res => {
        console.log(res.data);
        this.posts = [...res.data.posts];
      });
  }
};
</script>