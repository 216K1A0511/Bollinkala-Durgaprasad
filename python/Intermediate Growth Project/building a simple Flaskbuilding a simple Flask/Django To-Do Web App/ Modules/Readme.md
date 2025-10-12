# To-Do Web App (Flask/Django) - Intermediate Growth Project

This project guides you through building a simple, modular To-Do Web Application using Python with Flask or Django. The process is broken down into daily modules for steady, skill-focused growth from CLI to web development.

***

## Project Roadmap: Modules & Days

### Day 1: Setup & Kickoff
- Create Python environment (`venv`/`virtualenv`)
- Install Flask or Django
- Run “Hello World” in browser
- Create project directory structure

### Day 2: Basic Routing & Views
- Design routes: Home, Add Task, View Tasks
- Simple task display (static data)
- Create HTML templates (Jinja/Django templates)

### Day 3: Task Management Logic
- Implement Add Task route/form
- Store tasks in memory (Flask) or DB model (Django)
- Update tasks after adding

### Day 4: Persistent Storage
- Integrate SQLite database
- Define Task model/class
- Enable saving, retrieving, deleting tasks

### Day 5: Template & UI Improvements
- Use template loops for dynamic task rendering
- Add delete buttons
- Style with Bootstrap or CSS

### Day 6: Simple Authentication (Login/Logout)
- Registration & login routes
- Tasks linked to users
- Store users in DB (username/password)

### Day 7: Review, Test, and Polish
- Add error handling
- Bug and edge case testing
- Code commenting and folder cleanup
- Write README and finalize features

***

## Project Structure Example (Flask)

```text
/your_todo_app
    /templates
        index.html
        login.html
    app.py
    models.py
    forms.py
    /static
        style.css
    README.md
    requirements.txt
```

- **app.py**: App setup, route/controller definitions
- **models.py**: Task & User models, DB logic
- **forms.py**: Input form classes (using WTForms, optional)
- **templates/**: HTML templates for web pages
- **static/**: CSS, images, JS files

***

## Features

- Add/View/Delete tasks
- User registration and login
- Tasks stored per user
- Responsive template design
- Secure, scalable architecture

***

## Next Steps & Expansion Ideas

- Add due dates, priorities, completion status
- Advanced authentication/security
- API integration (Flask/Django REST)
- Analytics dashboard
- Deployment: Heroku, Render, or custom VPS

***

## Getting Started

1. Clone this repo.
2. Create venv:  
   ```bash
   python -m venv venv
   source venv/bin/activate
   ```
3. Install dependencies:  
   ```bash
   pip install flask
   # or
   pip install django
   ```
4. Run app:  
   ```bash
   python app.py
   # or
   python manage.py runserver
   ```

***

## License

Copyright (c) 2025 [Bollinkala Durgaprasad]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
