<template>
  <section>
    <b-nav tabs>
      <b-nav-item @click="changeCategory(1)">Solicitudes</b-nav-item>
      <b-nav-item @click="changeCategory(2)">Ofertas</b-nav-item>
      <b-nav-item @click="changeCategory(3)">General</b-nav-item>
    </b-nav>
    <b-card v-if="loggedIn" bg-variant="light">
      <b-container fluid>
        <b-row>
          <b-col>
            <b-avatar variant="info" :src="actual_user.picture"></b-avatar>
          </b-col>
          <b-col cols="9">
            <b-form-textarea v-model="user_post" size="sm" placeholder="Post something"></b-form-textarea>
            <b-button type="button" @click="handlePublish">Publish</b-button>
          </b-col>
        </b-row>
      </b-container>
    </b-card>
    <Posts :category="category" :showMore="false" :new_posts="new_posts"/>
  </section>
</template>

<script>
import Posts from '../components/Post';
import { mapGetters } from 'vuex';

export default {
  name: "Feed",
  components: {
    Posts
  },
  data: () => ({
    category: 1,
    actual_user: {},
    user_post: '',
    new_posts: []
  }),
  methods: {
    changeCategory(newCategory) {
      this.category = newCategory;
      this.new_posts = [];
    },
    handlePublish() {
      this.$axios
      .post("http://localhost:8000/api/post/create_post", {
        body: this.user_post,
        main_category: this.category,
        sub_category: 0
      })
      .then(res => {
        console.log(res.data);
        this.new_posts = [...this.new_posts, {
          body: this.user_post,
          user_information: {
            first_name: this.actual_user.first_name,
            last_name: this.actual_user.last_name,
            picture: this.actual_user.picture
          }
        }]
        this.user_post = '';
      });
    }
  },
  beforeMount() {
    this.$axios.get("http://localhost:8000/api/auth/user").then(res => {
      console.log(res.data);
      this.actual_user = { ...res.data.user };
    });
  },
  computed: {
    ...mapGetters(['loggedIn'])
  },
};
</script>