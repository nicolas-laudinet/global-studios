$(function () {
  $('#addWork').click(addWorkForm);
});


/**
  * Ajoute un formulaire d'un travail d'un studio à la suite du/des autre(s)
  */
function addWorkForm () {
  let workForm = getNewWorkForm();
  $('.work').last().after(workForm);
  setWorkFieldsNames()
  updateWorksCount()
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
    else if (element.type === 'radio') element.checked = false;
  });

  workForm.find('textarea').val(null);

  setDeleteButton(workForm);

  return workForm;
}


/**
  * Attache un écouteur d'évènement au bouton supprimer d'un formulaire d'un travail
  * @param {JQuery Element} workForm Un element Jquery contenant le formulaire à supprimer
  */
function setDeleteButton(workForm) {
    let deleteWork = workForm.find('.deleteWorkBtn');
    deleteWork.css({display: 'block'});
    deleteWork.click(function() {
      workForm.remove();
      setWorkFieldsNames()
      updateWorksCount()
    });
}


/**
  * Met à jour l'input caché #worksCount qui enregistre le nombre de travaux envoyés
  */
function updateWorksCount() {
  let worksLength = $('.work').length;
  $('#worksCount').val(worksLength);
}

/**
  * Défini les champs "name" d'un formulaire de travail, ainsi que leurs id et les champs for de leurs labels
  * Ajoute la position du formulaire de travail à la fin des champs
  * Ex: name="title-1" pour le champ title du deuxième formulaire de travail
  *
  */
function setWorkFieldsNames() {
  $('.work').each(function(index, element) {
    let inputs = element.querySelectorAll('input');

    for(let i = 0; i < inputs.length; i++) {
      if(inputs[i].name !== 'thumbnail') {
        let name = inputs[i].name.split('-')[0];
        inputs[i].name = name + '-' + index;
        inputs[i].id = name + '-' + index;
        inputs[i].previousElementSibling.htmlFor = name + '-' + index; // le label de l'input ciblé
      }
    }

    let textarea = element.querySelector('textarea');
    textarea.name = 'imageDescr-' + index;
    textarea.id = 'imageDescr-' + index;
    textarea.previousElementSibling.htmlFor = 'imageDescr-' + index;

  });
}
