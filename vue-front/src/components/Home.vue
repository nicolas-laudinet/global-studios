<template>
  <div id="home">
    <div class="welcome-phrase item-wrapper">
      <h1 class="welcome">Welcome to Global Studios.</h1>
      <p class="discover">Discover a selection of graphic design studios from around the world</p>
      <div class="arrow-container">
        <i class="down-arrow"></i>
      </div>
    </div>

    <div class="featured-wrapper">
      <Featured
        v-if="fetched"
        v-bind:featured-studio="featuredStudio"
      ></Featured>
    </div>

    <div :v-if="fetched" id="main" class="item-wrapper">
      <h2 class="last-uploads">Last Uploads</h2>
      <div class="stroke"></div>

      <div class="studio-container" v-for="(studio, idx) in getLastStudios(2)" :key="idx">

        <div class="studio">

            <h3 id="studio-name">{{ studio.name }}</h3>
            <p class="country">{{ studio.country.toUpperCase() }}</p>

            <div class="studio-img-text">
              <div v-for="(work, idx) in studio.works" :key="idx">
                <div v-if="work.featured == 1" class="work">
                  <img
                    :src="rootURL + '/images/' + work.img_path"
                    :alt="work.alt_text"
                    :title="work.title"
                    class="work-img"
                  >
                </div>
              </div>
              <p class="studio-description"> {{ studio.description.slice(0, 300) }} [...]
                <router-link :to="{ name: 'StudioSingle', params: {id: studio.id} }">
                  <i class="read-more">Read more...</i>
                </router-link>
              </p>
            </div>



        </div>
        <div class="studio-separator"></div>
      </div>
    </div>
    <router-link to="/list">
      <h3 class="discover-more item-wrapper">Discover more studios from around the globe</h3>
    </router-link>

  </div>
</template>

<script>
import Featured from '@/components/Featured'

export default {
  components: {
    Featured
  },
  name: 'Home',
  data () {
    return {
      studios: null,
      featuredStudio: null,
      fetched: false,
      rootURL: process.env.VUE_APP_ROOT
    }
  },
  methods: {
    fetchStudios() {
      fetch(this.rootURL + '/api/studios.php', {mode: 'cors'})
      .then((response) => {
        response.json().then((studios) => {
          //tri les studios par date d'ajout au site
          studios.sort((a, b) => {
            if(a.added_at > b.added_at) return -1;
            if(a.added_at < b.added_at) return 1;
            if(a.added_at === b.added_at) return 0;
          });

          //extrait au hasard un element du tableau
          this.featuredStudio = studios.splice(Math.floor(Math.random() * studios.length), 1)[0];

          this.studios = studios;
          this.fetched = true;
        });
      });
    },
    isWorkFeatured(work) {
      if(work.featured == 1) return work;
      else return false;
    },
    getLastStudios(number) {
      let studios = [];
      if(this.fetched) {
        for(let i = 0; i < number; i++) {
          studios.push(this.studios[i]);
        }
      }
      return studios;
    }
  },
  created() {
    this.fetchStudios();
  }
}
</script>
