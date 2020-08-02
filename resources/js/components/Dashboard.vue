<template>
    <div class="container">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 class="card_1">{{ data.all_projects }}</h3>

                    <p>All Projects </p>
                </div>
                <div class="icon">
                    <i class="fa fa-project-diagram"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3 class="card_2">
                        <!-- <sup style="font-size: 20px"></sup> -->
                    </h3>

                    <p>Active Projects</p>
                </div>
                <div class="icon">
                    <i class="fa fa-clipboard-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                <div class="inner">
                    <h3 class="card_3"></h3>

                    <p>Registered Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3 class="card_4"></h3>

                    <p>Active Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</template>

<script>
    export default {
        data() {			
			return {		
                data : {},				
			}
        },
        methods: {
            loadData() {
                axios.get('fetchData')
                .then(( {data} ) => (
                    $(".card_1").html(data.all_projects),                
                    $(".card_2").html(data.active_projects),                
                    $(".card_3").html(data.website_users),                
                    $(".card_4").html(data.active_users)                
                ))
                .catch(function(error) {
                    console.log(error);
                });      
            }
        },
        created() {
            this.loadData();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
