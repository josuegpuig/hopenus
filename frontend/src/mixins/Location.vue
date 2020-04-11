<script>
export default {
  methods: {
    getLocation() {
      if (navigator.geolocation) {
        this.$store.commit("setStatusCoords", 'Updating');
        navigator.geolocation.getCurrentPosition(
          this.showPosition,
          this.showError
        );
      } else {
        console.log("Geolocation is not supported by this browser.");
      }
    },

    showPosition(position) {
      console.log(position.coords.latitude);
      console.log(position.coords.longitude);
      let results = { status: true, coords: position };
      this.$store.commit("setCoords", results);
      if (this.google && this.map) {
        let bounds = new this.google.maps.LatLngBounds();
        let initialLocation = new this.google.maps.LatLng(
          position.coords.latitude,
          position.coords.longitude
        );
        bounds.extend(initialLocation);
        this.map.setCenter(initialLocation);
        this.map.fitBounds(bounds);
      }
    },

    showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          console.log("User denied the request for Geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
          console.log("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          console.log("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          console.log("An unknown error occurred.");
          break;
      }
      let results = { status: false, error: error };
      this.$store.commit("setCoords", results);
    }
  }
};
</script>