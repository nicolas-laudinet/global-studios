<template>
  <div id="studios-list">

    <div class="item-wrapper">
      <h2>Studios From Around The Globe</h2>
      <div class="stroke"></div>
      <select v-if="countriesFetched" class="country-select" v-model="countrySelected" @change="initPage()">
        <option value="0">Worldwide</option>
        <option v-for="(country, idx) in countries" :key="idx" :value="country.id">{{ country.name }}</option>
      </select>

      <div v-if="studiosFetched" class="studios-list">
        <div v-for="studio in selectedStudios" :key="studio.id" class="studio">

          <router-link :to="{ name: 'StudioSingle', params: {id: studio.id} }">
            <div class="img-item-list" v-for="featuredWork in getFeaturedWork(studio)" :key="featuredWork.id">
              <img
                :src="'http://global-studios.test/images/' + featuredWork.img_path"
                :alt="featuredWork.alt_text"
                :title="featuredWork.title"
              >
            </div>

            <div class="studio-name">{{ studio.name }}</div>
          </router-link>

          <div class="country">{{ studio.country }}</div>

        </div>
        <div class="pagination">
          <i v-for="(pageNumber, idx) in pagesNumber" :key="idx" @click="setPage(idx)" :class="activeIndex(idx)">{{ idx + 1 }}</i>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      studios: [],
      studiosFetched: false,
      countries: [],
      countriesFetched: false,
      countrySelected: 0,
      studiosPerPage: 6,
      pageSelected: 0,
      studiosByCountry: []
    }
  },
  computed: {
    selectedStudios() {

      let studiosByCountry = [];
      let countryId = parseInt(this.countrySelected);

      if(countryId === 0) {
        studiosByCountry = this.studios;
        this.setStudiosByCountry(this.studios);

      } else {
        studiosByCountry = this.studios.filter((studio) => {
          return studio.country_id == countryId;
        });
        this.setStudiosByCountry(studiosByCountry);
      }

      let studiosByPage = [];
      for(let i = this.studiosPerPage * this.pageSelected; i < ((this.pageSelected + 1) * this.studiosPerPage) && i < studiosByCountry.length; i++) {
        studiosByPage.push(studiosByCountry[i]);
      }

      return studiosByPage;
    },
    pagesNumber() {
      return Math.ceil(this.studiosByCountry.length / this.studiosPerPage);
    }
  },
  methods: {
    initPage() {
      console.log('there');
      this.pageSelected = 0;
    },
    setStudiosByCountry(studios) {
      this.studiosByCountry = studios;
    },
    activeIndex(index) {
      if(index == this.pageSelected) {
        return 'active-index';
      }
    },
    setPage(index) {
      this.pageSelected = index;
    },
    getFeaturedWork(studio) {
    return  studio.works.filter((work) => {
      return work.featured == 1;
      })
    },
    fetchStudios() {
      fetch(`http://${process.env.VUE_APP_ROOT}/api/studios.php`, {mode: 'cors'})
      .then((response) => {
        response.json().then((studios) => {
          //tri les studios par date d'ajout au site
          studios.sort((a, b) => {
            if(a.added_at > b.added_at) return 1;
            if(a.added_at < b.added_at) return -1;
            if(a.added_at === b.added_at) return 0;
          });

          this.studios = studios;
          this.studiosFetched = true;
        });
      });
    },
    fetchCountries() {
      fetch(`http://${process.env.VUE_APP_ROOT}/api/countries.php`, {mode: 'cors'})
      .then((response) => {
        response.json().then((countries) => {
          this.countries = countries;
          this.countriesFetched = true;
        });
      });
    }
  },
  created() {
    this.fetchStudios();
    this.fetchCountries();
  }
}
</script>
