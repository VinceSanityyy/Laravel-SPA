<template>
    <div>
        
        <a href="#"  data-toggle="modal" data-target="#addNew" @click="update(params.data)">
                  <i class="fa fa-edit"></i>
                </a>
        <a href="#" @click="deleteUser(params.data.id)">
                  <i class="fa fa-trash text-red"></i>
                </a>
    </div>
</template>
<script>
export default {
    data() {
        return {
            
        }
    },
    mounted() {
        console.log(this.params)
    },
    methods: {
        update(data) {
            Fire.$emit('updated', data)
        },
        deleteUser(id) {
            Fire.$emit('deleted', id)
        }

    }
}
</script>