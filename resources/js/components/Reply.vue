<template>
    <div :ref="`reply-${data.id}`" class="card mt-4" >
        <div class="card-header">
            <div class="level">
                <div>
                    <a :href="`/profiles/${data.owner.name}`">{{ data.owner.name }}</a> said
                    {{ data.created_at }}:
                </div>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer d-flex" v-if="canUpdate">
            <button class="btn btn-sm btn-primary mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
        </div>

    </div>
</template>

<script>
import Favorite from "./Favorite";
export default {
    name: "Reply.vue",
    props: ['data'],
    components: {
      Favorite
    },
    data() {
        return {
            editing: false,
            body: this.data.body
        }
    },
    computed: {
        signedIn() {
            return window.App.signedIn;
        },
        canUpdate() {
            return this.authorize(userId => this.data.user_id === userId);
            // return this.data.user_id === window.App.userId;
        }
    },
    methods: {
        async update() {
            await axios.patch(`/replies/${this.data.id}`, {
                body: this.body
            });

            this.editing = false;

            flash('Updated!');
        },
        async destroy() {
            await axios.delete(`/replies/${this.data.id}`);
            this.$emit('deleted', this.data.id);
        }
    }
}
</script>

<style>

</style>
