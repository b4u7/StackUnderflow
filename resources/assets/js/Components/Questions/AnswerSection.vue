<template>
  <div class="answer-section">
    <div class="question-controls">
      <votes
        :total-votes="answer.votes_sum_vote || 0"
        :can-vote="permissions.canVote"
        :user-vote="userVote"
        @upvoted="addVote"
        @downvoted="removeVote"
      />
    </div>
    <answer-card :answer="answer" :permissions="permissions"></answer-card>
  </div>
</template>

<script>
import AnswerCard from "@/Components/Questions/Answer";
import Votes from "@/Components/Questions/Votes";

export default {
  name: "AnswerSection",
  components: { AnswerCard, Votes },
  props: {
    answer: {
      type: Object,
      required: true
    },
    permissions: {
      type: Object,
      required: true
    },
    userAnswerVote: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      classes: {
        success: "text-emerald-600",
        danger: "text-red-600"
      }
    };
  },
  computed: {
    voteSumColour() {
      let voteSum = this.answer.votes_sum_vote;

      if (voteSum > 0) {
        return this.classes.success;
      } else if (voteSum < 0) {
        return this.classes.danger;
      }
    },
    userVote() {
      return this.userQuestionVote?.vote ?? 0;
    }
  },
  methods: {
    addVote() {
      this.$inertia.post(route("answers.upvote", [this.answer.question_id, this.answer]));
    },
    removeVote() {
      this.$inertia.post(route("answers.downvote", [this.answer.question_id, this.answer]));
    }
  }
};
</script>

<style scoped></style>
