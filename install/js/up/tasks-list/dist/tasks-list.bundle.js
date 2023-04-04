this.BX = this.BX || {};
this.BX.Up = this.BX.Up || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject;
	var TasksList = /*#__PURE__*/function () {
	  function TasksList() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, TasksList);
	    if (main_core.Type.isStringFilled(options.rootNodeId)) {
	      this.rootNodeId = options.rootNodeId;
	    } else {
	      throw new Error('TasksList: options.rootNodeId requered');
	    }
	    this.rootNode = document.getElementById(this.rootNodeId);
	    if (!this.rootNode) {
	      throw new Error("TasksList: element with \"".concat(this.rootNodeId, "\" not found"));
	    }
	    this.tasksList = [];
	    this.currentPage = options.currentPage;
	    this.reload();
	  }
	  babelHelpers.createClass(TasksList, [{
	    key: "reload",
	    value: function reload() {
	      var _this = this;
	      this.loadList().then(function (tasksList) {
	        _this.tasksList = tasksList;
	        _this.render();
	      });
	    }
	  }, {
	    key: "loadList",
	    value: function loadList() {
	      var _this2 = this;
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('up:tasks.task.getTasksList', {
	          data: {
	            currentPage: _this2.currentPage
	          }
	        }).then(function (response) {
	          var tasksList = response.data.tasksList;
	          resolve(tasksList);
	        })["catch"](function (error) {
	          reject(error);
	        });
	      });
	    }
	  }, {
	    key: "render",
	    value: function render() {
	      var _this3 = this;
	      this.rootNode.innerHTML = '';
	      if (!this.rootNode.classList.contains('card-container')) {
	        this.rootNode.classList.add('card-container');
	      }
	      this.tasksList.forEach(function (task) {
	        var taskNode = main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["\n\t\t\t\t<div class=\"card\">\n            \t\t<header class=\"card-header\">\n                \t\t<a href=\"/task/", "/\" class=\"card-header-title\">\n                    \t\t", "\n                \t\t</a>\n                \t\t<a class=\"card-header-icon button is-outlined is-size-5\" aria-label=\"important\">\n                    \t\t<i class=\"fa fa-star favorite-icon\" aria-hidden=\"true\"></i>\n                \t\t</a>\n            \t\t</header>\n            \t\t<div class=\"card-content\">\n                \t\t<div class=\"content\">\n                    \t\t<div class=\"card-description\">\n                        \t\t", "\n                    \t\t</div>    \n                    \t\t<div class=\"metadata is-bordered\">\n                        \t\t", "           \n                    \t\t</div>\n                \t\t</div>\n            \t\t</div>\n            \t\t<footer class=\"card-footer p-1\">\n                \t\t", "\n                \t\t<button onClick='deleteTask(", "); return false;' class=\"card-footer-item button task-btn bad\" title=\"\u042D\u0442\u0430 \u0437\u0430\u0434\u0430\u0447\u0430 \u0431\u0443\u0434\u0435\u0442 \u0443\u0434\u0430\u043B\u0435\u043D\u0430\">\n\t\t\t\t\t\t\t<i class=\"fa fa-trash fa-lg mr-1\"></i>\u0423\u0434\u0430\u043B\u0438\u0442\u044C\n                \t\t</button>\n            \t\t</footer>\n        \t\t</div>\n\t\t\t"])), task.ID, task.TITLE, task.DESCRIPTION, _this3.includeDeadlineTag(task), _this3.includeCompleteButton(task), task.ID);
	        _this3.rootNode.appendChild(taskNode);
	      });
	    }
	  }, {
	    key: "completeTask",
	    value: function completeTask(taskId) {
	      var _this4 = this;
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('up:tasks.task.completeTask', {
	          data: {
	            taskId: taskId
	          }
	        }).then(function (response) {
	          _this4.reload();
	          alert('Успешно. Круто, что ты такой продуктивный!');
	        })["catch"](function (error) {
	          console.log(error);
	        });
	      });
	    }
	  }, {
	    key: "deleteTask",
	    value: function deleteTask(taskId) {
	      var _this5 = this;
	      var confirmation = confirm('Вы уверены, что хотите удалить эту задачу?');
	      if (confirmation) {
	        return new Promise(function (resolve, reject) {
	          BX.ajax.runAction('up:tasks.task.deleteTask', {
	            data: {
	              taskId: taskId
	            }
	          }).then(function (response) {
	            _this5.reload();
	            alert('Задача успешно удалена!');
	          })["catch"](function (error) {
	            alert('Что-то пошло не так, извините! Чтобы узнать, в чем дело зайдите в консоль разработчика');
	            console.log(error);
	          });
	        });
	      }
	    }
	  }, {
	    key: "unCompleteTask",
	    value: function unCompleteTask(taskId) {
	      var _this6 = this;
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('up:tasks.task.unCompleteTask', {
	          data: {
	            taskId: taskId
	          }
	        }).then(function (response) {
	          _this6.reload();
	          alert('Окей, я отметил, что задача не выполнена!');
	        })["catch"](function (error) {
	          console.log(error);
	        });
	      });
	    }
	  }, {
	    key: "createTask",
	    value: function createTask(title, description, deadline) {
	      var _this7 = this;
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('up:tasks.task.createTask', {
	          data: {
	            title: title,
	            description: description,
	            deadline: deadline
	          },
	          method: 'POST'
	        }).then(function (response) {
	          closeCreatingTaskPanel();
	          _this7.reload();
	          alert('Все круто, задача создана!');
	        })["catch"](function (error) {
	          reject(error);
	        });
	      });
	    }
	  }, {
	    key: "includeDeadlineTag",
	    value: function includeDeadlineTag(task) {
	      if (task.IS_COMPLETED == '1') {
	        return "<span class=\"tag is-medium is-success\">\u0412\u044B\u043F\u043E\u043B\u043D\u0435\u043D\u043E</span> ";
	      } else {
	        return "<span class=\"tag ".concat(this.getColorForDeadline(task.DEADLINE), " is-medium\">Deadline: ").concat(this.formatDeadline(task.DEADLINE), "\n\t\t\t\t\t\t<time datetime=\"05-12-2002T18:00\"> </time>\n\t\t\t\t\t</span> ");
	      }
	    }
	  }, {
	    key: "includeCompleteButton",
	    value: function includeCompleteButton(task) {
	      if (task.IS_COMPLETED == '0') {
	        return "<button onClick='completeTask(".concat(task.ID, "); return false;' class=\"card-footer-item button mr-1 task-btn good\" title=\"\u042D\u0442\u0430 \u0437\u0430\u0434\u0430\u0447\u0430 \u0431\u0443\u0434\u0435\u0442 \u0432\u044B\u043F\u043E\u043B\u043D\u0435\u043D\u0430\">\n\t\t\t\t<i class=\"fa fa-check-circle-o fa-lg mr-1\" aria-hidden=\"true\"></i>\u0412\u044B\u043F\u043E\u043B\u043D\u0438\u0442\u044C\n\t\t\t</button>");
	      } else {
	        return "<button onClick='unCompleteTask(".concat(task.ID, "); return false;' class=\"card-footer-item button mr-1 task-btn bad\" title=\"\u042D\u0442\u0430 \u0437\u0430\u0434\u0430\u0447\u0430 \u0431\u0443\u0434\u0435\u0442 \u0432\u044B\u043F\u043E\u043B\u043D\u0435\u043D\u0430\">\n\t\t\t\t<i class=\"fa fa-times-circle-o fa-lg mr-1\" aria-hidden=\"true\"></i>\u041E\u0442\u043C\u0435\u043D\u0438\u0442\u044C \u0432\u044B\u043F\u043E\u043B\u043D\u0435\u043D\u0438\u0435\n\t\t\t</button>");
	      }
	    }
	  }, {
	    key: "formatDeadline",
	    value: function formatDeadline(deadline) {
	      var date = new Date(deadline);
	      var options = {
	        month: 'long',
	        day: 'numeric',
	        hour: 'numeric',
	        minute: 'numeric',
	        timezone: 'UTC'
	      };
	      return date.toLocaleString("ru", options);
	    }
	  }, {
	    key: "getColorForDeadline",
	    value: function getColorForDeadline(date) {
	      var deadline = new Date(date);
	      var currentTime = Date.now();
	      var onTheWeek = new Date('Jan 9 1970');
	      var onTheDay = new Date('Jan 2 1970');
	      var differentDates = new Date(deadline - currentTime);
	      if (differentDates > onTheWeek) return 'is-info';
	      if (differentDates > onTheDay) return 'is-warning';else return 'is-danger';
	    }
	  }]);
	  return TasksList;
	}();

	exports.TasksList = TasksList;

}((this.BX.Up.Tasks = this.BX.Up.Tasks || {}),BX));
