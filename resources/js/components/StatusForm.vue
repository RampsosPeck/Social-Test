<template>
    <div>
    <form  @submit.prevent="submit">

        <div class="card-body">
            <textarea v-model="body" el class="form-control border-0 bg-light" name="body" placeholder="Qué estás pensando Jorge?"></textarea>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" id="create-status">Publicar</button>
        </div>
    </form>

    </div>
</template>

<script>
    export default {
        name: "StatusForm",
        data(){
            return {
                body: ''
            }
        },
        methods: {
            submit() {
                 axios.post('/statuses', {body: this.body})
                     .then(res =>{
                        EventBus.$emit('status-created', res.data.data);
                        //this.statuses.push(res.data);
                        this.body = ''
                     })
                     .catch(err =>{
                         console.log(err.response.data)
                     })
            }
        }
    }
</script>

<style scoped>

</style>
