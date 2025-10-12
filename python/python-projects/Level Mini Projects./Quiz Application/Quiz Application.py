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
