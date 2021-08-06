<script>
import Replies from "../Replies";
export default {
    name: "Thread.vue",
    props: ['initialRepliesCount'],
    components: {
        Replies
    },
    data() {
        return {
            repliesCount: this.initialRepliesCount
        }
    }
}
</script>

<style scoped>

</style>
