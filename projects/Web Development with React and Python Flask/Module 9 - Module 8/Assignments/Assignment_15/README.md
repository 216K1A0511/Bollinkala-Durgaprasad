
# Test Section Timer Component

## Objective

Implement a timer component using `react-timer-hook` to manage the duration of each test section in the IELTS Speaking Test platform. Display the timer alongside test questions to help users track their remaining time effectively.

## Requirements

1. **Timer Integration**:

   - Use `react-timer-hook` or an equivalent library to create a countdown timer.
   - Configure the timer to count down from a predefined duration (e.g., 2 minutes per question).

2. **Component Design**:

   - Display the timer prominently alongside the test questions.
   - Include visual or textual cues when time is about to expire (e.g., changing text color or displaying a warning).

3. **State Management**:

   - Use React state to manage the timer’s start, pause, and reset functionality.
   - Synchronize the timer with the test question progression.

4. **Error Handling**:

   - Handle edge cases, such as when the timer expires or the user navigates away mid-test.

5. **Styling**:
   - Ensure the timer component is visually appealing and aligns with the platform’s UI theme.

## Setup Process

1. **Environment Setup**:

   - Ensure you have a React development environment ready.
   - Install `react-timer-hook` using npm or yarn:
     ```sh
     npm install react-timer-hook
     ```

2. **Timer Integration**:

   - Import the timer library in your component file.
   - Configure the timer to count down from a predefined duration.

3. **Component Design**:

   - Create a Timer component that displays prominently alongside test questions.
   - Use visual or textual cues when time is about to expire.

4. **State Management**:

   - Use React state and effects to manage start, pause, and reset functionalities.
   - Synchronize the timer with test question progression using state or context.

5. **Error Handling**:

   - Handle timer expiry by displaying alerts or auto-transitioning to the next question.
   - Manage user navigation cases by pausing and maintaining timer states.

6. **Styling**:
   - Match the Timer component to the platform’s UI theme.
   - Ensure readability and accessibility, including screen reader compatibility and clear visual feedback.

## Testing Evidence

### Screenshots

Include screenshots demonstrating the timer in action, integrated successfully alongside test questions.

### Screen Recordings

Provide screen recordings showing the timer's functionality, including start, pause, reset, and expiry scenarios.

## Submission Guidelines

1. Submit the Timer component file and any updates to the test interface.
2. Provide a description of the setup process and testing evidence.
3. Include screenshots or screen recordings showing the timer in action.

## Evaluation Criteria

1. **Timer Functionality (40%)**:

   - The timer accurately counts down and displays the remaining time.

2. **Integration with Test Interface (30%)**:

   - The timer synchronizes with test sections and is prominently displayed.

3. **Styling and User Experience (20%)**:

   - The timer is visually appealing and provides clear feedback to users.

4. **Submission Completeness (10%)**:
   - All required files and testing evidence are included.

## Key Considerations

- Ensure the timer is reusable and modular for potential future use in other test sections.
- Add accessibility features like screen reader compatibility and clear visual cues.
