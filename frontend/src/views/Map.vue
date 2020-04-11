<template>
  <div id="mapCanvas"></div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import MarkerClusterer from "@google/markerclusterer";
import gmapsInit from "../utils/gmaps";

export default {
  name: "Map",
  data: () => ({
    google: undefined,
    locations: undefined
  }),
  methods: {
    handleTrack() {
      navigator.geolocation.getCurrentPosition(
        position => {
          console.log(position.coords.latitude);
          console.log(position.coords.longitude);
        },
        error => {
          console.log(error.message);
        }
      );
    }
  },
  computed: {
    ...mapState(["coordinates"]),
    ...mapGetters(["activeLocation", "userCoordinates"])
  },
  async mounted() {
    try {
      const google = await gmapsInit();
      this.google = google;
      const geocoder = new google.maps.Geocoder();
      var mapOptions = {
        mapTypeId: "roadmap"
      };
      const map = new google.maps.Map(this.$el, mapOptions);
      this.map = map;

      map.setTilt(50);

      geocoder.geocode({ address: "Mexico" }, (results, status) => {
        console.log(status);
        if (status !== "OK" || !results[0]) {
          throw new Error(status);
        }

        map.setCenter(results[0].geometry.location);
        map.fitBounds(results[0].geometry.viewport);
      });

      this.$axios
        .get("http://localhost:8000/api/post/get_locations")
        .then(res => {
          this.locations = res.data.locations.map(location => {
            return {
              position: {
                lat: Number(location.latitude),
                lng: Number(location.longitude)
              }
            };
          });

          let content = res.data.locations.map(location => {
            return `
              <div class="info_content">
                <h3>${location.latitude}</h3>
                <p>${location.body}</p>
              </div>
            `;
          });

          let infoWindow = new google.maps.InfoWindow();

          const markerClickHandler = (marker,i) => {
            infoWindow.setContent(content[i]);
            infoWindow.open(map, marker);
            //map.setZoom(13);
            //map.setCenter(marker.getPosition());
          };

          //Markers
          const markers = this.locations.map((location,i) => {
            const marker = new google.maps.Marker({ ...location, map });
            marker.addListener("click", () => markerClickHandler(marker,i));

            return marker;
          });
          // TODO: filter markers with same lat and lng to show pointer
          new MarkerClusterer(map, markers, {
            imagePath:
              "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
          });
        })
        .catch(err => {
          console.log(err);
        });
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style scoped>
#mapCanvas {
  height: 80vh;
}
</style>