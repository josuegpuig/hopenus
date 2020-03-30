<template>
  <section v-if="posts.length > 0">
    <b-card v-for="(post,i) in posts" :key="i">
      <div>
        <b-avatar variant="info" :src="post.user_information.picture"></b-avatar>
        {{ post.user_information.first_name }} {{ post.user_information.last_name }}
      </div>

      <b-card-text>{{ post.body }}</b-card-text>

      <router-link
        :to="{ name: 'Post', params: {id: post.id} }"
        class="card-link"
      >{{ post.comments_count }} Comentarios</router-link>
    </b-card>
  </section>
</template>

<script>
export default {
  props: ["posts"],
  data() {
    return {
      mainProps: { width: 40, height: 40, class: "m1" }
    };
  }
};
</script>