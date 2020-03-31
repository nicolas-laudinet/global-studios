$(function () {
  $('#addWork').click(addWorkForm);
});

function addWorkForm () {
  console.log('clicked !');
  let workForm = getEmptyWorkForm();
  $('.work').last().after(workForm);
}

/**
  * Récupère le dernier champ de formulaire 'WORK' réinitialise tous ses champs.
  */
function getEmptyWorkForm () {
  let workForm = $('.work').last().clone();

  workForm[0].querySelector('textarea').value = null;

  let workInputs = workForm[0].querySelectorAll('input');

  for(let i = 0; i < workInputs.length; i++) {
    if(workInputs[i].type === 'text') {
      workInputs[i].value = null;
    }

    else if (workInputs[i].type === 'file') {
      workInputs[i].value = null;
    }

    else if (workInputs[i].type === 'checkbox') {
      workInputs[i].checked = false;
    }
  }

  return workForm;
}
