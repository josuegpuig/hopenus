<template>
  <div>
    <b-form-input v-model="search" placeholder="Search..."></b-form-input>
    <b-button @click="handleSearch">Search</b-button>
    <Loading v-if="loaded == false" />
    <SearchResults :posts="posts" />
  </div>
</template>

<script>
import SearchResults from "../components/SearchResults";
import Loading from "../components/Loading";

export default {
  name: "Search",
  components: {
    SearchResults,
    Loading
  },
  data: () => ({
    search: "",
    posts: [],
    loaded: true
  }),
  methods: {
    handleSearch() {
      this.loaded = false;
      this.$axios.post('http://localhost:8000/api/search', {
        search: this.search
      }).then(res => {
        this.posts = res.data.posts;
        this.loaded = true;
      })
    }
  }
};
</script>