/*
 * Form Validation
 *User account
 */
$(function () {
  $("#formChangePwd").validate({
    rules: {
      inputPasswordOld: {
        required: true,
      },
      inputPasswordNew: {
        required: true,
        minlength: 5,
      },
      inputPasswordNewConfirm: {
        required: true,
        minlength: 5,
        equalTo: "#inputPasswordNew",
      },
    },
    //For custom messages
    messages: {
      inputPasswordOld: {
        required: "Enter old password",
      },
      inputPasswordNew: {
        required: "Enter new password",
      },
      inputPasswordNewConfirm: {
        required: "Enter confirm password again",
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formLogin").validate({
    rules: {
      email: {
        required: true,
      },
      password: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      email: {
        required: "Enter email / username",
      },
      password: {
        required: "Enter password",
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formArea").validate({
    rules: {
      area: {
        required: true,
        minlength: 5
      },
      description: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      area: {
        required: "Enter area name",
        minlength: "Enter at least 5 characters"
      },
      description: {
        required: "Enter description",
        minlength: "Enter at least 5 characters"
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formRoleUpdate").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      description: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      name: {
        required: "Enter role name",
        minlength: "Enter at least 5 characters"
      },
      description: {
        required: "Enter description",
        minlength: "Enter at least 5 characters"
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formRole").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      description: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      name: {
        required: "Enter role name",
        minlength: "Enter at least 5 characters"
      },
      description: {
        required: "Enter description",
        minlength: "Enter at least 5 characters"
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formLocation").validate({
    rules: {
      location: {
        required: true,
        minlength: 5
      },
      description: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      location: {
        required: "Enter location name",
        minlength: "Enter at least 5 characters"
      },
      description: {
        required: "Enter description",
        minlength: "Enter at least 5 characters"
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formCustomer").validate({
    rules: {
      nickname: {
        required: true,
        minlength: 5
      },
      phone: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      nickname: {
        required: "Enter a nick name",
        minlength: "Enter at least 5 characters"
      },
      phone: {
        required: "Enter a phone number",
        minlength: "Enter at least 9 characters"
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formCategories").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      cat_file: {
        required: true
      },
      description: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      name: {
        required: "Enter a Category name",
        minlength: "Enter at least 5 characters"
      },
      description: {
        required: "Enter a description",
        minlength: "Enter at least 5 characters"
      },
      cat_file: {
        required: "Please Choose your image"
      }
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formAccountEdit").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      email: {
        required: true,
        minlength: 5
      },
      phone: {
        required: true
      },
    },
    //For custom messages
    messages: {
      name: {
        required: "Enter a full name",
        minlength: "Enter at least 5 characters"
      },
      email: {
        required: "Enter a email",
        minlength: "Enter at least 5 characters"
      },
       phone: {
        required: "Enter a phone number"
      },
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formAccount").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      email: {
        required: true,
        minlength: 5
      },
      //profile: {
      //  required: true
      //},
      password: {
        required: true,
        minlength: 5
      },
      password_confirmation: {
        required: true,
        minlength: 5,
        equalTo: "#password"
      },
      phone: {
        required: true
      },
    },
    //For custom messages
    messages: {
      name: {
        required: "Enter a full name",
        minlength: "Enter at least 5 characters"
      },
      email: {
        required: "Enter a email",
        minlength: "Enter at least 5 characters"
      },
       phone: {
        required: "Enter a phone number"
      },
      profile: {
        required: "Please Choose your image"
      },
      password:"Enter new password",
      password_confirmation:"Enter password again",
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formbanner").validate({
    rules: {
      description: {
        required: true,
        minlength: 5
      },
      bann_file: {
        required: true
      },
    },
    //For custom messages
    messages: {
      bann_file: {
        required: "Please Choose your image"
      },
      description: {
        required: "Enter a description",
        minlength: "Enter at least 5 characters"
      }
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $("#formSub").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      categeory: {
        required: true
      },
      description: {
        required: true,
        minlength: 5
      },
    },
    //For custom messages
    messages: {
      name: {
        required: "Enter a Sub category name",
        minlength: "Enter at least 5 characters"
      },
      description: {
        required: "Enter a description",
        minlength: "Enter at least 5 characters"
      },
      categeory: {
        required: "Please Choose categeories"
      }
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

});

