<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <router-link :to="{ name: 'HomeNews' }" class="navbar-brand">Hopenus</router-link>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <router-link :to="{ name: 'Feed' }" class="nav-link">Posts</router-link>
          <router-link :to="{ name: 'Search' }" class="nav-link">Search</router-link>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <!-- <b-button size="sm" class="my-2 my-sm-0" type="button" @click="handleTrack">Track</b-button> -->
          <!-- <b-nav-form>
            <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
          </b-nav-form> -->

          <b-nav-item-dropdown text="Lang" right>
            <b-dropdown-item v-for="(lang, i) in langs" :key="`Lang${i}`" :value="lang" href="#" @click="handleLocale(lang)">{{ lang }}</b-dropdown-item>
          </b-nav-item-dropdown>

          <FacebookLogin v-show="false" />
          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template v-slot:button-content>
              <em>User</em>
            </template>
            <b-dropdown-item v-if="loggedIn" @click="handleLogout">Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
import i18n from '../i18n'
import FacebookLogin from "../components/FacebookLogin";
import { mapGetters, mapState } from 'vuex';

export default {
  name: 'Navbar',
  components: {
    FacebookLogin,
  },
  data () {
    return { langs: ['en', 'es'] }
  },
  methods: {
    handleLocale(lang) {
      i18n.locale = lang;
    },
    handleTrack() {
      navigator.geolocation.getCurrentPosition(
        position => {
          console.log(position.coords.latitude);
          console.log(position.coords.longitude);
        },
        error => {
          console.log(error.message);
        },
      )   
    },
    handleLogout() {
      this.$axios
      .post("http://localhost:8000/api/auth/logout")
      .then(() => {
        this.scope_login.logout();
        localStorage.removeItem('token');
      });
    }
  },
  computed: {
    ...mapState(['scope_login']),
    ...mapGetters(['loggedIn'])
  },
}
</script>