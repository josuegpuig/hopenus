<template>
  <section>
    <b-card>
      <div>
        <b-avatar
          variant="info"
          :src="post.user_information.picture"
        ></b-avatar>
        {{ post.user_information.first_name }} {{ post.user_information.last_name }}
      </div>

      <b-card-text>{{ post.body }}</b-card-text>

      <b-link href="#" class="card-link">{{ post.comments_count }} Comentarios</b-link>
    </b-card>
    <b-card v-for="(comment,i) in comments" :key="i">
      <b-row>
        <b-col>
          <b-avatar
            variant="info"
            :src="comment.user_information.picture"
          ></b-avatar>
        </b-col>

        <b-col cols="9">
          {{ comment.user_information.first_name }} {{ comment.user_information.last_name }}
          <b-card-text>{{ comment.body }}</b-card-text>
        </b-col>
      </b-row>
    </b-card>

    <b-card v-if="loggedIn" bg-variant="light">
      <b-container fluid>
        <b-row>
          <b-col>
            <b-avatar variant="info" :src="actual_user.picture"></b-avatar>
          </b-col>
          <b-col cols="9">
            <b-form-textarea v-model="user_comment" size="sm" placeholder="Comment something"></b-form-textarea>
            <b-button type="button" @click="handlePublish">Publish</b-button>
          </b-col>
        </b-row>
      </b-container>
    </b-card>
  </section>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      post: {
        user_information: {}
      },
      comments: [],
      actual_user: {},
      user_comment: '',
    };
  },
  methods: {
    handlePublish() {
      let params = this.$route.params;
      this.$axios
      .post("http://localhost:8000/api/post/create_comment", {
        post_id: params.id,
        body: this.user_comment
      })
      .then(() => {
        this.comments = [...this.comments, {
          body: this.user_comment,
          user_information: {
            first_name: this.actual_user.first_name,
            last_name: this.actual_user.last_name,
            picture: this.actual_user.picture
          }
        }]
        this.user_comment = '';
      });
    }
  },
  computed: {
    ...mapGetters(['loggedIn'])
  },
  beforeMount() {
    let params = this.$route.params;
    this.$axios
      .post("http://localhost:8000/api/post/post_details", {
        id: params.id
      })
      .then(res => {
        this.post = { ...res.data.post };
      });
    this.$axios
      .post("http://localhost:8000/api/post/comments_post", {
        post_id: params.id
      })
      .then(res => {
        this.comments = [...res.data.comments];
      });
    this.$axios.get("http://localhost:8000/api/auth/user").then(res => {
      this.actual_user = { ...res.data.user };
    });
  }
};
</script>