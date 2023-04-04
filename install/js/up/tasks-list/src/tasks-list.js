import { Type, Tag } from 'main.core';

export class TasksList {
	constructor(options = {}) 
	{
		if (Type.isStringFilled(options.rootNodeId)) {
			this.rootNodeId = options.rootNodeId;
		}
		else {
			throw new Error('TasksList: options.rootNodeId requered');
		}

		this.rootNode = document.getElementById(this.rootNodeId);
		if (!this.rootNode) {
			throw new Error(`TasksList: element with "${this.rootNodeId}" not found`)
		}

		this.tasksList = [];
		this.currentPage = options.currentPage;
		this.reload();

	}

	reload() {
		this.loadList()
			.then(tasksList => {
				this.tasksList = tasksList;
				this.render();
			});
	}

	loadList() {
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:tasks.task.getTasksList',{
				data: {
					currentPage: this.currentPage,
				}
			})
    			.then((response) => {
        			let tasksList = response.data.tasksList;
					resolve(tasksList);
    			})
    			.catch((error) => {
					reject(error)
				});
		});
	}

	render() {
		this.rootNode.innerHTML = '';

		if (!this.rootNode.classList.contains('card-container')) {
			this.rootNode.classList.add('card-container')
		}

		this.tasksList.forEach(task => {
			const taskNode = Tag.render`
				<div class="card">
            		<header class="card-header">
                		<a href="/task/${task.ID}/" class="card-header-title">
                    		${task.TITLE}
                		</a>
                		<a class="card-header-icon button is-outlined is-size-5" aria-label="important">
                    		<i class="fa fa-star favorite-icon" aria-hidden="true"></i>
                		</a>
            		</header>
            		<div class="card-content">
                		<div class="content">
                    		<div class="card-description">
                        		${task.DESCRIPTION}
                    		</div>    
                    		<div class="metadata is-bordered">
                        		${this.includeDeadlineTag(task)}           
                    		</div>
                		</div>
            		</div>
            		<footer class="card-footer p-1">
                		${this.includeCompleteButton(task)}
                		<button onClick='deleteTask(${task.ID}); return false;' class="card-footer-item button task-btn bad" title="Эта задача будет удалена">
							<i class="fa fa-trash fa-lg mr-1"></i>Удалить
                		</button>
            		</footer>
        		</div>
			`;

			this.rootNode.appendChild(taskNode);
		});
	}

	completeTask(taskId)
	{
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:tasks.task.completeTask',{
				data: {
					taskId: taskId,
				}
			})
    			.then((response) => {
					this.reload();
					alert('Успешно. Круто, что ты такой продуктивный!');
    			})
    			.catch((error) => {
					console.log(error);
				});
		});
	}

	deleteTask(taskId)
	{
		let confirmation = confirm('Вы уверены, что хотите удалить эту задачу?'); 

		if (confirmation)
		{
			return new Promise((resolve, reject) => {
				BX.ajax.runAction('up:tasks.task.deleteTask',{
					data: {
						taskId: taskId,
					}
				})
					.then((response) => {
						this.reload();
						alert('Задача успешно удалена!');

					})
					.catch((error) => {
						alert('Что-то пошло не так, извините! Чтобы узнать, в чем дело зайдите в консоль разработчика');
						console.log(error);
					});
			});	
		}
	}

	unCompleteTask(taskId)
	{
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:tasks.task.unCompleteTask',{
				data: {
					taskId: taskId,
				}
			})
    			.then((response) => {
					this.reload();
					alert('Окей, я отметил, что задача не выполнена!');
    			})
    			.catch((error) => {
					console.log(error);
				});
		});
	}

	createTask(title, description, deadline)
	{
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('up:tasks.task.createTask',{
				data: {
					title: title,
					description: description,
					deadline: deadline,
				},
				method: 'POST',
			})
    			.then((response) => {
					closeCreatingTaskPanel();
					this.reload();
        			alert('Все круто, задача создана!');
    			})
    			.catch((error) => {
					reject(error)
				});
		});
	}

	includeDeadlineTag(task)
	{
		if (task.IS_COMPLETED == '1')
		{
			return `<span class="tag is-medium is-success">Выполнено</span> `
		}
		else
		{
			return `<span class="tag ${this.getColorForDeadline(task.DEADLINE)} is-medium">Deadline: ${this.formatDeadline(task.DEADLINE)}
						<time datetime="05-12-2002T18:00"> </time>
					</span> `;
		}
	}

	includeCompleteButton(task)
	{
		if (task.IS_COMPLETED == '0'){
			return `<button onClick='completeTask(${task.ID}); return false;' class="card-footer-item button mr-1 task-btn good" title="Эта задача будет выполнена">
				<i class="fa fa-check-circle-o fa-lg mr-1" aria-hidden="true"></i>Выполнить
			</button>`;
		}
		else
		{
			return `<button onClick='unCompleteTask(${task.ID}); return false;' class="card-footer-item button mr-1 task-btn bad" title="Эта задача будет выполнена">
				<i class="fa fa-times-circle-o fa-lg mr-1" aria-hidden="true"></i>Отменить выполнение
			</button>`;
		}
	}

	formatDeadline(deadline)
	{
		let date = new Date(deadline);
		var options = {
			month: 'long',
			day: 'numeric',
			hour: 'numeric',
			minute: 'numeric',
			timezone: 'UTC'
		};
		
		return date.toLocaleString("ru", options);
	}

	getColorForDeadline(date)
	{
		let deadline = new Date(date);
		let currentTime = Date.now();

		let onTheWeek = new Date('Jan 9 1970');
		let onTheDay = new Date('Jan 2 1970');

		let differentDates = new Date(deadline - currentTime);

		if (differentDates > onTheWeek) return 'is-info';
		if (differentDates > onTheDay) return 'is-warning';
		else return 'is-danger';
	}
}


