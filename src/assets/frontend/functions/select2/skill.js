let SkillSelect2 = {
  init: function () {
      $('#skill, #skill_validate').select2({
          placeholder: 'Select a skill',
          tags: true
      });
  }
};

jQuery(document).ready(function () {
  SkillSelect2.init();
});
