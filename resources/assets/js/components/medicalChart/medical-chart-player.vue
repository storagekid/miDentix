<template v-if="screenHeight && playerPages.length">
    <div id="medical-chart-player">
            <div v-for="(playerPage, pageId) in playerPages" :key="pageId" v-if="pageId == page">
                <div
                class="player-group-container"
                v-for="(jobTypeGroup, groupId) in playerPage"
                :key="groupId"
                >
                    <div
                    class="fx fx-col"
                    >
                    <div
                        class="player-row medical-chart-header"
                        >
                        <h4 
                            class="player-name fx fx-center"
                            v-for="(jobType, index) in models.job_types.items"
                            :key="index"
                            v-if="jobType.id == groupId"
                            >
                            {{jobType.name}} 
                        </h4>
                    </div>
                    <transition-group appear enter-active-class="animated slower flipInX" tag="div">
                        <div
                        class="player-row personal-chart"
                        v-for="(profile, index) in jobTypeGroup"
                        :key="index"
                        >
                            <h4 class="player-name fx fx-center">
                                {{profile.name + ' ' + profile.lastname1}}
                                <span class="license" v-if="license">{{' - Nº de Licencia: ' + profile.personal_id_number}}</span>   
                            </h4>
                        </div>
                    </transition-group>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: ['license'],
        data() {
            return {
                medicalJobIds: [1,2,4,6,8],
                medicalJobTypesIds: [1,2,4,6,7,9,11,12],
                screenWidth : window.innerWidth,
                screenHeight : window.innerHeight,
                start : 0,
                page : 0,
                first : true,
            }
        },
        computed: {
        //   playerPages() {
        //     return Math.ceil(((this.clinicJobs.length + this.medicalStaff.length) * 100) / this.screenHeight);
        //   },
          playerRows() {
            return this.clinicJobs.length + this.medicalStaff.length;
          },
          models() {
            return this.$store.state.Model.models;
          },
          clinicJobs() {
            let items = [];
            for (let profile of this.models.profiles.items) {
              if (this.medicalJobTypesIds.includes(profile.job_type_id)) {
                if (!items.includes(profile.job_type_id)) {
                  items.push(profile.job_type_id);
                }
              }
            }
            return items;
          },
          medicalStaff() {
            // let vm = this;
            // return this.models.profiles.items.filter((profile) => this.medicalJobIds.include(profile.job_id));
            let items = [];
            for (let profile of this.models.profiles.items) {
              if (this.medicalJobIds.includes(profile.job_id)) {
                items.push(profile);
              }
            }
            return items;
          },
          groupedProfiles() {
              let grouped = {};
              for (let item of this.models.profiles.items) {
                    if (this.medicalJobTypesIds.includes(item.job_type_id)) {
                        if (!grouped[item.job_type_id]) {
                        grouped[item.job_type_id] = [];
                        grouped[item.job_type_id].push(item);
                    } else {
                        grouped[item.job_type_id].push(item);
                    }
                  }
              }
              return grouped;
          },
          playerPages() {
              let pages = [];
              let page = {};
              let counter = 0;
              let currentHeight = 0;
              for (let group in this.groupedProfiles) {
                  counter++;
                  currentHeight += ((this.groupedProfiles[group].length+1) * 100);
                //   console.log('Current Height: ' + currentHeight);
                  if (currentHeight < this.screenHeight) {
                      page[group] = this.groupedProfiles[group];
                      if (counter == Object.keys(this.groupedProfiles).length) {
                          pages.push(page);
                      }
                  } else {
                      pages.push(page);
                      currentHeight = ((this.groupedProfiles[group].length+1) * 100);
                      page = {};
                      page[group] = this.groupedProfiles[group];
                  }
              }
              return pages;
          },
        //   pageIndex() {
        //       setInterval(function(){ 
        //           if (this.first) {
        //               this.first = false;
        //               return this.page;
        //           } else if (this.page == this.playerPages.length-1) {
        //               this.page = 0;
        //               return this.page;
        //           } else {
        //               this.page++;
        //               return this.page;
        //           }
        //       }, 1000);
        //   }
        },
        methods: {
            startInterval: function () {
                setInterval(() => {
                    if (this.first) {
                        this.first = false;
                        // console.log(this.page);
                        return;
                    }
                    if (this.page == this.playerPages.length-1) {
                        this.page = 0;
                    } else {
                        this.page = parseInt(this.page) + 1;
                    }
                    // console.log(this.page);
                }, 5000);
            },
          jobInClinic(id) {
            if (this.$store.state.Model.models.profiles) {
              if (this.$store.state.Model.models.profiles.items) {
                for (let profile of this.$store.state.Model.models.profiles.items) {
                  if (profile.job_type_id == id && this.medicalJobTypesIds.includes(id)) {
                    return true;
                  }
                }
              }
            }
      
            return false;
          },
        },
        created() {
        },
        mounted() {
            this.startInterval();
            // let self = this;
            // setInterval(function(){ 
                // if (this.page == 1) {
                //     this.page = 0;
                // } else {
                //     this.page = parseInt(this.page) + 1;
                // }
            //     console.log(self.page);
            //   }, 1000);
        },
    }
</script>
<style type="text/css">
</style>