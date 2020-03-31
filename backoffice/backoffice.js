$(function () {
  $('#addWork').click(addWorkForm);
});

/**
  * Ajoute un formulaire d'un travail d'un studio à la suite du/des autre(s)
  */
function addWorkForm () {
  let workForm = getNewWorkForm();
  $('.work').last().after(workForm);
}

/**
  * Récupère le dernier champ de formulaire 'WORK' réinitialise tous ses champs.
  * @return Un nouveau formulaire vièrge de présentation d'un travail du studio
  */
function getNewWorkForm () {
  let workForm = $('.work').last().clone();
  let workInputs = workForm.find('input');

  workInputs.each(function (index, element) {
    if(element.type === 'text') element.value = null;
    else if (element.type === 'file') element.value = null;
    else if (element.type === 'checkbox') element.checked = false;
  });

  //selectionne le textarea à l'interieur de .work et le set à null
  workForm.find('textarea').val(null);

  setDeleteButton(workForm);

  return workForm;
}

function setDeleteButton(workForm) {
    let deleteWork = workForm.find('.deleteWorkBtn');
    deleteWork.css({display: 'block'});
    deleteWork.click(function() {
      workForm.remove();
    });
}
