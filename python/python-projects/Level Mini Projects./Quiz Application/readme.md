# Python Quiz Application

## Project Overview
This application is a modular quiz program, supporting both multiple-choice and input-based questions with a scoring system. It is built for console use and designed to easily expand into a GUI using tkinter or PyQt in future updates.[4][1]

## Key Features
- Multiple-choice question support[1]
- Input/text-based question support[1]
- Scoring and result display[1]
- Simple question addition via code or external files[1]
- Modular structure for GUI upgrades[1]

## How It Works
- Users answer questions in the console
- Both MCQ and text formats supported
- Instant scoring after the quiz
- Future upgrades ready for GUI integration

## Example Code Structure
```python
class Question:
    def __init__(self, prompt, answer, options=None):
        self.prompt = prompt
        self.options = options or []
        self.answer = answer

def ask_mcq(question):
    print(question.prompt)
    for idx, option in enumerate(question.options):
        print(f"{idx+1}. {option}")
    user_input = input("Choose option number: ")
    return question.options[int(user_input)-1] == question.answer

def ask_text(question):
    print(question.prompt)
    user_input = input("Your answer: ")
    return user_input.strip().lower() == question.answer.lower()

def run_quiz(questions):
    score = 0
    for q in questions:
        if q.options:
            correct = ask_mcq(q)
        else:
            correct = ask_text(q)
        score += int(correct)
    print(f"Final Score: {score}/{len(questions)}")

questions = [
    Question("Capital of India?", "New Delhi", ["Mumbai", "New Delhi", "Kolkata"]),
    Question("Who is the current president of USA?", "Donald Trump"),
]

run_quiz(questions)
```

## Getting Started
- Clone this repository
- Run the Python script: `python quiz_app.py`
- Answer questions and view your final score

## Expansion Ideas
- Store questions in JSON or CSV for easy editing[1]
- Add features: timed quizzes, multiple quiz sets, leaderboards
- Convert console logic to GUI with tkinter or PyQt
- Add callbacks and event triggers for GUI functionality[4]

## Contribution
Feel free to fork and enhance the project—add new question formats, advanced features, or GUI components. Pull requests are welcome!

## License
Below is a simple MIT License text for your "LICENSE" file. This license is widely used for open-source projects and allows others to use, modify, and distribute your code with minimal restriction.[1][2]

***
Copyright (c) 2025 Bollinkala Durgaprasad

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the “Software”), to deal
in the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.



