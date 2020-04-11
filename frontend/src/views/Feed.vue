<template>
  <section>
    <b-nav tabs>
      <b-nav-item @click="changeCategory(1)">Requests</b-nav-item>
      <b-nav-item @click="changeCategory(2)">Offers</b-nav-item>
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
          </b-col>
          <div class="col-12">
            <b-form-checkbox
              v-model="location"
              value="accepted"
              unchecked-value="not_accepted"
            >Include my address</b-form-checkbox>
            <b-spinner v-if="this.statusPublish" type="grow" label="Loading..." variant="primary"></b-spinner>
            <b-button type="button" @click="handlePublish" v-if="!this.statusPublish">Publish</b-button>
          </div>
        </b-row>
      </b-container>
    </b-card>
    <Posts :category="category" :showMore="false" :new_posts="new_posts" />
  </section>
</template>

<script>
import Posts from "../components/Post";
import { mapGetters, mapState } from "vuex";
import Location from "../mixins/Location";
import gmapsInit from "../utils/gmaps";

export default {
  name: "Feed",
  mixins: [Location],
  components: {
    Posts
  },
  data: () => ({
    category: 1,
    actual_user: {},
    user_post: "",
    new_posts: [],
    location: "not_accepted",
    statusPublish: false,
    google: undefined,
    geocoder: undefined,
    address: undefined,
    latitude: undefined,
    longitude: undefined
  }),
  methods: {
    changeCategory(newCategory) {
      this.category = newCategory;
      this.new_posts = [];
    },
    handlePublish() {
      this.statusPublish = true;
      if (this.location === "accepted") {
        this.latitude = this.coordinates.coords.coords.latitude;
        this.longitude = this.coordinates.coords.coords.longitude;
        let latlng = new this.google.maps.LatLng(this.latitude, this.longitude);
        this.geocoder.geocode(
          {
            latLng: latlng
          },
          (results, status) => {
            if (status == this.google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                // TODO: check a better way to obtain city
                this.address = results[0].formatted_address;
                let city = results[0].formatted_address.split(",")[1];
                console.log(city);
              }
            }
            this.makePost();
          }
        );
        return;
      }

      this.makePost();
    },
    makePost() {
      this.$axios
        .post("http://localhost:8000/api/post/create_post", {
          body: this.user_post,
          main_category: this.category,
          sub_category: 0,
          latitude: this.latitude ? this.latitude : null,
          longitude: this.longitude ? this.longitude : null,
          marker_title: this.category,
          address: this.address ? this.address : null
        })
        .then(() => {
          this.new_posts = [
            ...this.new_posts,
            {
              body: this.user_post,
              user_information: {
                first_name: this.actual_user.first_name,
                last_name: this.actual_user.last_name,
                picture: this.actual_user.picture
              },
              address: this.address ? this.address : null
            }
          ];
          this.user_post = "";
          this.location = "not_accepted";
          this.statusPublish = false;
        });
    }
  },
  beforeMount() {
    this.$axios.get("http://localhost:8000/api/auth/user").then(res => {
      this.actual_user = { ...res.data.user };
    });
  },
  computed: {
    ...mapGetters(["loggedIn"]),
    ...mapState(["coordinates"])
  },
  watch: {
    location: function(value) {
      if (value === "accepted") {
        this.statusPublish = true;
        this.getLocation();
        this.unwatch = this.$store.watch(
          (state, getters) => getters.status_coordinates,
          (newValue, oldValue) => {
            console.log(`Updating from ${oldValue} to ${newValue}`);

            // Do whatever makes sense now
            if (newValue === "Updated") {
              console.log(this.coordinates);
              this.statusPublish = false;
            }
          }
        );
        return;
      }
      this.unwatch();
    }
  },
  async mounted() {
    try {
      this.google = await gmapsInit();
      this.geocoder = new this.google.maps.Geocoder();
    } catch (error) {
      console.error(error);
    }
  },
  beforeDestroy() {
    this.unwatch();
  }
};
</script>