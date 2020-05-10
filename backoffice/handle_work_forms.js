$(function () {
  let worksCount = updateWorksCount();

  if(worksCount > 1) {
    $('.work').each(function(index) {
      setDeleteButton($(this));
    })
  }

  if($('.work-id').first().val()) {
    $('.work').each(function (index) {
      let id = $(this).find('.work-id').val();
      $(this).find('.deleteWorkBtn').click(function() {
        fetch('http://global-studios.test/api/delete_work.php?id=' + id, {
          mode: 'cors',
          method: 'GET'
        }).then((response) => {
          console.log(response);
          response.json((json) => {
            console.log(json);
            console.log('a');
          });
        });
      })
    })
  } else {
    console.log('no val')
  }

  $('#addWork').click(addWorkForm);
});


/**
  * Ajoute un formulaire d'un travail d'un studio à la suite du/des autre(s)
  */
function addWorkForm () {
  let workForm = getNewWorkForm();
  $('.work').last().after(workForm);

  if($('.work').length > 1) {
    setDeleteButton($('.work').first());
  }

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

      if($('.work').length <= 1) {
        hideDeleteButton($('.work').first());
      }

    });
}


/**
  * Met à jour l'input caché #worksCount qui enregistre le nombre de travaux envoyés
  */
function updateWorksCount() {
  let worksLength = $('.work').length;
  $('#worksCount').val(worksLength);
  return worksLength;
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

function hideDeleteButton(workForm) {
  let btn = workForm.find('.deleteWorkBtn');
  btn.css({display: 'none'});
}
