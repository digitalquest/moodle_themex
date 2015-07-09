$(document).ready(function() {

  // load walkthrough stylesheets
  $(function() {
    $('<link/>', {
      rel: 'stylesheet',
      type: 'text/css',
      href: 'http://moodle.warwick.ac.uk/theme/warwickclean/style/introjs.css'
    }).appendTo('head');
  $('<link/>', {
    rel: 'stylesheet',
    type: 'text/css',
    href: 'http://moodle.warwick.ac.uk/theme/warwickclean/style/nazanin.css'
  }).appendTo('head');
});
  var url = window.location.href;

  // Main walkthrough page
  if (url == 'http://moodle.warwick.ac.uk/course/view.php?id=11832') {
    $('#page-navbar > nav > div > form > div > input[type="submit"]:nth-child(1)').attr({
      'data-intro': 'In this walkthrough you will learn how to add a Quiz to your Moodle course page and about some of the commonly used Quiz settings.<p><strong>Click \'Turn editing on\' to get started.</strong></p>',
      'data-step': 1
    });

    // adding attributes for walkthrough 2
    $('#module-118246').css("display", "none");

    // this button launches walkthrough 1
    $('#launch_walk').on('click', function() {
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
      introJs().setOptions({
        exitOnOverlayClick: false,
        showButtons: false
      }).start();
    });
  }

  // step 2
  if (url == 'http://moodle.warwick.ac.uk/course/view.php?id=11832&notifyeditingon=1') {
    $('#section-1').attr({
      "data-intro": "Under the \'Quizzes\' heading, click <strong>\'Add activity or resource\'</strong>",
      "data-step": 2,
      "data-position": "left"
    });
    introJs().setOptions({
      exitOnOverlayClick: false,
      showButtons: true
    }).start();

    // step 3
    $('#section-1 .section-modchooser-text').on('click', function() {
      introJs().exit();

      // timeouts allow DOM elements to load
      setTimeout(function() {
        $('.path-course-view.moodle-dialogue-base.moodle-dialogue').attr(
          "style", "z-index: 9999999 !important;"
        );
        $('.moodle-dialogue-base.yui3-widget').attr(
          "style", "z-index: 9999999 !important;"
        );
      }, 200);
      setTimeout(function() {
        $('.yui3-widget-mask.moodle-dialogue-lightbox').css("display", "none");
        top = $('div.moodle-dialogue-base > div:nth-child(2)').css("top");
        left = $('div.moodle-dialogue-base > div:nth-child(2)').css("left");
        $('div.moodle-dialogue-base > div:nth-child(2)').attr({
          "data-intro": "Select Quiz activity and click Add",
          "data-step": 3,
          "data-position": "right",
          "style": "top: " + top + "; left: " + left + "; width: 540px; z-index: 9999999 !important"
        });
        introJs().setOptions({
          exitOnOverlayClick: false,
          disableInteraction: false
        }).start().nextStep();
      }, 300);
    });
  }

  // main quiz setting form
  if (url.indexOf("modedit.php?add=quiz&type=&course=11832") > 0) {
    $('#fitem_id_name').attr({
      "data-intro": "You must give your Quiz a name, this will identify it on the Moodle course page. When you\'re done, click \'Next\'",
      "data-position": "left"
    });
    $('#id_name').attr("value", "My First Quiz");
    $('#fitem_id_introeditor').attr({
      "data-intro": "An optional description that will be displayed below the Quiz link on the course page",
      "data-position": "left"
    });
    $('#id_timing').attr({
      "data-intro": "Other Quiz settings can be expanded on this page.\n\nQuiz accessibility is opened ended by default, click \'Enable\' next to Open and Close times to change this. Similarly for \'Time Limit\'.\n\nClicking the question mark icons on this page offer further information about settings if you are unsure",
      "data-position": "left"
    });
    $('#id_modstandardgrade').attr({
      "data-intro": "These settings relate to how many Quiz attempts are allowed per student, and how the student's grade will be counted againt their grades in Moodle",
      "data-position": "left"
    });
    $('#id_interactionhdr').attr({
      "data-intro": "For multiple-choice or matching questions you can set it so that answers are shuffled per attempt. More information on question behaviour can be found in <a href=\"https://docs.moodle.org/28/en/Question_behaviours\">Moodle documentation</a>",
      "data-position": "left"
    });
    $('#id_overallfeedbackhdr').attr({
      "data-intro": "As well as feedback which can be set per question, here you can specify feedback presented to students upon quiz completion. This can be arranged according to grade boundaries.\n\nSome example grade boundaries are provided here, feel free to change these and add some text in the \'feedback\' box.",
      "data-position": "left"
    });
    $('#id_submitbutton').attr({
      "data-intro": "There are more settings you might consider on this page, but for now click the \'Save and display\' button to be taken to your newly created quiz, ready to begin adding questions",
      "data-position": "left"
    });

    introJs().setOptions({
      exitOnOverlayClick: false,
      disableInteraction: false
    }).start().onbeforechange(function(targetElementId) {

      // expands collapsed sections and imports some values as examples
      switch (targetElementId.id) {
        case 'id_timing':
        case 'id_modstandardgrade':
        case 'id_interactionhdr':
          $('#' + targetElementId.id).removeClass("collapsed");
          break;
        case 'id_overallfeedbackhdr':
          $('#' + targetElementId.id).removeClass("collapsed");
          $('#id_feedbackboundaries_0').attr("value", "80%");
          $('#id_feedbackboundaries_1').attr("value", "70%");
          $('#id_feedbackboundaries_2').attr("value", "55%");
          $('#id_feedbackboundaries_3').attr("value", "40%");
          break;
        default:
          break;
      }
    });
  }

  // ##### end walkthrough 1



  // ##### Begin Walthrough 2

  // click button to highlight quiz element
  $('#launch_addQ').on('click', function() {
    $('#module-118246').css("display", "list-item");

    var intro2 = introJs();
    intro2.setOptions({
      steps: [{
        element: '#module-118246',
        intro: "This is the Quiz activity we will be practicing with. Go ahead, click it",
        position: 'left'
      }],
      exitOnOverlayClick: false,
      showButtons: false
    });
    intro2.start();
  });

  // page where you click edit
  if ($(document.body).hasClass("cmid-118246")) {
    $('#region-main > div > div.box.quizattempt > div.singlebutton > form > div').attr({
      "data-intro": "Once you are here, at the Quiz page, click <strong>Edit Quiz</strong> to begin adding questions",
      "data-position": "left",
      "data-step": 2
    });
    introJs().setOptions({
      showButtons: false,
      exitOnOverlayClick: false
    }).start();
  }

  // quiz edit page where you add questions
  if ($(document.body).attr("id") == "page-mod-quiz-edit" && $(document.body).hasClass("cmid-118246")) {
    $('#region-main > div > div.box.quizattempt > div.singlebutton > form > div').attr({
      "data-intro": "Once you are here, at the Quiz page, click <strong>Edit Quiz</strong> to begin adding questions",
      "data-position": "left",
      "data-step": 2
    });

    var intro3 = introJs();
    $("#region-main").attr({
      "data-intro": "When creating a quiz, the main concepts are: <ul> <li> The <strong>quiz</strong>, containing questions over one or more pages </li> <li> The <strong>question bank</strong>, which stores copies of all questions organised into categories </li><li> <strong>Random questions</strong> - A student gets different questions each time they attempt the quiz and different students can get different questions </li> </ul><p><strong>Click \'Add a quesiton\' <span style=\"font-size: 1.4em;\">\u27f9</span></strong>.",
      "data-position": "left",
      "data-step": 3
    });
    intro3.setOptions({
      showButtons: false,
      exitOnOverlayClick: false
    }).start();

    $('#quizcontentsblock > div.editq > div.quizpage > div > div.pagecontrols > div:nth-child(1) > form > div > input[type="submit"]:nth-child(1)').on('click', function() {
      intro3.exit();

      setTimeout(function() {
        $('#qtypechoicecontainer').attr({
          "data-intro": 'Clicking a quesiton type in this popup reveals some more information about it on the right-hand side. For this walkthrough, select \'<strong>All-or-nothing multiple choice<strong>\'.',
          "data-position": 'right',
          "data-step": 4
        });
      }, 200);

      setTimeout(function() {
        introJs().setOptions({
          showButtons: false,
          exitOnOverlayClick: false
        }).start().nextStep();
      }, 300);
    });
  }

  // all or nothing multiple choice question page (page-question-type-multichoiceset)
  if ($(document.body).attr("id") == "page-question-type-multichoiceset" && $(document.body).hasClass("cmid-118246")) {
    $('#fitem_id_category').attr({
      "data-intro": "The \'Category\' field indicates at which directory in the Moodle page hierarchy you want this question to be stored. The default setting stores the question at \'course level\' so that you can easily access it in other Quiz instances throughout your course. Leave this field as it is and <strong>click \'next\'</strong>",
      "data-position": "left"
    });
    $('#id_name').attr("value", "My First Question");
    $('#fitem_id_name').attr({
      "data-intro": "This name helps identify your quesiton in the quesiton bank. Feel free to change this.",
      "data-position": "left"
    });
    $('#id_questiontext').attr("value", "How many movements in Schubert's Unfinished Symphony?");
    $('#fitem_id_questiontext').attr({
      "data-intro": "In this box you put the actual text that poses the question, using the editor you can include images and video if you want",
      "data-position": "left"
    });
    $('#fitem_id_generalfeedback').attr({
      "data-intro": "General feedback is shown to the student after they have completed the question. Unlike specific feedback, which depends on the question type and what response the student gave, the same general feedback text is shown to all students.\n\nYou can use the general feedback to give students a fully worked answer and perhaps a link to more information they can use if they did not understand the questions.",
      "data-position": "left"
    });
    $('#fitem_id_shuffleanswers').attr({
      "data-intro": "If enabled, the order of the answers is randomly shuffled for each attempt, provided that \"Shuffle within questions\" in the activity settings is also enabled.",
      "data-position": "left"
    });
    $('#id_choicehdr_0').attr({
      "data-intro": "This is where you add multiple choice answers. Each \'Choice\' heading expands to show some extra options for that answer, including feedback specifc to that answer choice",
      "data-position": "left"
    });
    $('#id_choicehdr_1').attr({
      "data-intro": "Add optional choice 2...",
      "data-position": "left"
    });
    $('#id_choicehdr_2').attr({
      "data-intro": "Add optional choice 3",
      "data-position": "left"
    });
    $('#id_choicehdr_3').attr({
      "data-intro": "Add optional choice 4 (last one, promise!)",
      "data-position": "left"
    });
    $('#id_overallfeedbackhdr').attr({
      "data-intro": "Slightly more specific than \'General Feedback\', you can offer different feedback responses for correct and incorrect answers",
      "data-position": "left"
    });
    $('#id_submitbutton').attr({
      "data-intro": "Congratulations you have just create an All-or-nothing Multiple Choice question and it has been added to the quiz.\n\n<strong>Click \'Save changes\'</strong>",
      "data-position": "left"
    });

    introJs().setOptions({
      showButtons: true,
      exitOnOverlayClick: false
    }).start().onbeforechange(function(targetElementId) {

      switch (targetElementId.id) {
        case 'id_choicehdr_0':
          $('#' + targetElementId.id).removeClass("collapsed");
        case 'id_choicehdr_1':
          $('#' + targetElementId.id).removeClass("collapsed");
        case 'id_choicehdr_2':
          $('#' + targetElementId.id).removeClass("collapsed");
        case 'id_choicehdr_3':
          $('#' + targetElementId.id).removeClass("collapsed");
        case 'id_overallfeedbackhdr':
          $('#' + targetElementId.id).removeClass("collapsed");
          break;
        default:
          break;

      }
    });
  }
  // ##### end walkthrough 2

});
