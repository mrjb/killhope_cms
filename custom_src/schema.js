var glossary_schema = {
	"definitions":{
		"word":{
			"type":"object",
			"properties":{
				"word": {"type":"string"},
				"definition": {"type":"string"},
				"Types":{
					"type":"array",
					"items":{
						"$ref": "#/definitions/word"
					}
				}
			},
			"title":"Word",
			"headerTemplate": "{{ i1 }} - {{ self.word}}",
			"required": ["word", "definition"],
			"defaultProperties": ["word", "definition"],
			"options":{
				"disable_edit_json":true,
				"disable_collapse":true
			}
		}
	},
	"title":"Edit",
	"type":"object",
	"options":{
		"disable_collapse":true,
		"disable_edit_json":true,
		"disable_properties":true
	},
	"properties":{
		"glossary":{
			"title": "Glossary",
			"type":"array",
			"format":"tabs",
			"options":{
				"disable_collapse":true
			},
			"items":{
				"$ref": "#/definitions/word"
			}
		} 
	}
};

var quiz_schema = {
  "type":"object",
  "title":"Quiz",
  "headerTemplate": "{{self.name}}",
  "options":{
    "disable_collapse":true,
    "disable_properties":true
  },


  "properties":{
	 "name":{"type":"string", "title":"Quiz Name"},
    "ordering":{"type":"number", "title":"Ordering (quizzes with a smaller number are listed before quizzes with a higher number)"},
    "published":{"type":"boolean", "format":"checkbox", "title":"Published (un-publish, instead of delete, when you wish to remove a quiz from the app that you might need again in the future).", "default":true},
    "questionList":{
      "title":"Question List",
      "format":"tabs",
      "type":"array",
      "options":{"disable_collapse":true},
      "items":{
        "type":"object",
	      "options":{
                "disable_edit_json":true,
                "disable_properties":true,
                "disable_collapse":true
	      },
        "headerTemplate": "Question {{ i1 }}",
        "properties":{
          "question":{"type":"string", "title":"Question"},
          "correctAnswer":{"type":"number", "title":"Correct Answer (It's number counting from 0)"}, 
          "answers":{
            "type":"array",
            "title":"Possible Answers",
            "items":{
              "type":"object",
              "headerTemplate": "Answer {{i0}}",
              "options":{
                "disable_properties":true,
                "disable_edit_json":true,
                "disable_collapse":true
              },
              "properties":{
                "answer":{"type":"string", "title":"Answer"}
              }
            }
          },
          
          "hint":{
            "type":"string", 
            "default":"Hint",
            "options":{"hidden":true} 
          }
        }
      }
    }
  }
};

var trail_schema = {
  "definitions":{
    "clue":{
      "type":"object",
      "options":{
        "collapsed":false,
        "disable_edit_json":true,
        "disable_properties":true
      },
      "headerTemplate":"{{self.clue}}",
      "properties":{
        "clue":{"title": "Clue", "type":"string"},
        "qrCode":{"title": "QR Encoded Text", "type":"string"},
        "info":{"title": "More Information (shown upon scanning QR code)","type":"string"},
        "hint":{"title": "Hint (optionally available before scanning QR code)", "type":"string"},
      }  
    }
  },
  "type":"object",
  "headerTemplate":"Edit {{self.name}}",
  "options":{"disable_properties":true, "disable_collapse":true},
  "properties":{
    "name":{"type":"string", "title":"Trail Name"},
    "ordering":{
      "type":"number", 
      "title":"Ordering (trails with a smaller number are listed before trails with a higher number)"
    },
    "published":{
      "type":"boolean", 
      "format":"checkbox", 
      "title":"Published (un-publish, instead of delete, when you wish to remove a trail from the app that you might need again in the future).", 
      "default":true
    },
    "overview":{"type":"string", "title":"Trail Overview"},
    "certificate_message":{
      "type": "string",
      "title": "Certificate Page Message (shown below the certificate once trail is completed)",
      "default": "Show this certificate at reception for a chance to win a small prize!"
    },
    "locationList":{
      "title":"Location List",
      "format":"tabs",
      "type":"array",
      "options":{"disable_collapse":true},
      "items":{
        "$ref": "#/definitions/clue"
      }
    }
  }
};

var mineral_schema = {
  "definitions":{
    "stage":{
      "type":"array",
      "options":{"collapsed":true},
      "items":{
        "type":"object",
        "options":{
          "disable_edit_json":true,
          "disable_properties":true,
          "collapse":true 
        },
        "headerTemplate":"{{self.title}}",
        "properties":{
          "title":{"type":"string"},
          "info":{"type":"string"}
        }
      }    
    }
  },
  "type":"object",
  "headerTemplate":"Edit {{self.name}}",
  "options":{"disable_properties":true, "disable_collapse":true},
  "properties":{
    "name":{"type":"string"},
    "formula":{"type":"string"},
    "3dcrystal":{"type":"string", "options":{"hidden":true}, "default":"mineral_ankerite_gif"},
    "qrcode":{"type":"string", "options":{"hidden":true}, "default":"killhope_museum_mineral_ankerite"},
    "images":{
      "type":"array", 
      "options":{"hidden":true}, 
      "items":{"type":"string"}, 
      "default":["mineral_ankerite_image_1"]
    },
    "stage1":{
      "title": "Stage 1",
      "$ref": "#/definitions/stage"
    },
    "stage2":{
      "title": "Stage 2",
      "$ref": "#/definitions/stage"
    },
    "stage3":{
      "title": "Stage 3",
       "$ref": "#/definitions/stage"
    },
    "stage4":{
      "title": "Stage 4",
      "$ref": "#/definitions/stage"
    }

  }
};
