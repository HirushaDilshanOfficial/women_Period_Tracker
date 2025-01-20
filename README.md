# women_Period_Tracker

Here's a more polished and attractive version of the FemCare project description for GitHub:

---

# FemCare: Empowering Women's Health

FemCare is a comprehensive menstrual health tracking system designed to empower women with the tools they need to monitor their menstrual cycles, symptoms, moods, and overall well-being. With features such as cycle tracking, symptom logging, mood monitoring, and community support, FemCare aims to provide personalized insights that help women understand their bodies better and manage their menstrual health effectively.

### Key Features

#### 🌸 **Cycle Tracking**
- **Log menstrual cycles**: Track start date, end date, and flow intensity.
- **Cycle Statistics**: Automatically calculates average cycle length, period length, and predicts the next period date.
- **History & Patterns**: View historical cycle data and track your cycle trends over time.

#### 🌺 **Symptom & Mood Tracking**
- **Symptom Logging**: Track common symptoms like cramps, headaches, fatigue, bloating, and more.
- **Mood Logging**: Record your mood on a daily basis and understand how it changes during your cycle.
- **Trends Visualization**: Use interactive charts to visualize symptom and mood patterns over the last 28 days.

#### 💬 **Community Support**
- **Forum Interaction**: Connect with other users through a community forum where you can share experiences, ask questions, and offer support.
- **Categories**: Engage in different topics such as General Discussion, Health Tips, Support, and Questions.
- **User Engagement**: Like, comment, and post to foster a supportive environment.

#### 🔔 **Notifications & Reminders**
- **Custom Reminders**: Get timely reminders for your upcoming periods, fertile windows, and medication schedules.
- **Customizable Alerts**: Personalize notification settings to match your needs.

#### 👤 **User Profile & Personalization**
- **Profile Management**: Update your personal details, including name, email, date of birth, and cycle information.
- **Quick Stats**: View essential stats like your next period date, average cycle length, and recent cycle history.
- **Track Your Progress**: Edit or delete past entries, and see how your cycles evolve over time.

#### 🔒 **Data Security**
- **Robust Security**: Uses secure session management, bcrypt password hashing, and input sanitization to protect user data.
- **CSRF Protection**: Safeguards against cross-site request forgery with tokens.
- **Privacy Focused**: Your data is yours to control, stored securely with respect to your privacy.

#### 🛠 **Admin Features**
- **User Management**: Admins can view and manage user accounts and cycle data.
- **Forum Moderation**: Admins have the ability to moderate posts and comments.
- **Analytics**: Access detailed reports on user activity and health trends to help improve the platform.

---

### Technical Stack

#### **Frontend**
- **Tailwind CSS**: Modern, responsive design that looks great on all devices.
- **Chart.js**: Beautiful and interactive visualizations for cycle and symptom trends.
- **AJAX**: Seamless data updates without page reloads for a smooth user experience.

#### **Backend**
- **PHP**: Core server-side logic and application flow.
- **MySQL**: A reliable and secure relational database to store user data.
- **PDO**: Secure and efficient database connection handling.

#### **Database Schema**
- **users**: Stores user details (name, email, password, DOB, etc.).
- **cycle_entries**: Contains detailed information about each logged cycle (start, end, flow intensity).
- **symptoms**: Logs daily symptoms (headaches, cramps, etc.) for each user.
- **posts**: Community forum posts and comments, with relationships to users.
- **posts_comments**: Supports comment threads and likes on forum posts.

#### **Security**
- **Sanitization & Validation**: Ensures protection against SQL injection and XSS attacks.
- **CSRF Tokens**: Prevents cross-site request forgery attacks.
- **Secure Sessions**: Uses session management to keep users logged in securely.

---

### How It Works

1. **User Registration & Login**: 
   - Users can sign up with basic details (name, email, DOB, password) and log in using session management.
   
2. **Cycle Tracking**:
   - Log cycle start and end dates, flow intensity, and track cycle statistics. The system will predict your next period date based on past data.

3. **Symptom & Mood Tracking**:
   - Record daily symptoms and moods to visualize your health patterns. Interactive charts help you see how symptoms correlate with your menstrual cycle.

4. **Community Forum**:
   - Users can post, comment, and interact with others in categories such as Health Tips, Support, and General Discussion.

5. **Notifications**:
   - Set custom reminders for upcoming periods, medication, and fertile windows.

---

### Why FemCare?

- **Personalized Insights**: Understand your body better with tailored health insights based on your cycle data.
- **Supportive Community**: Connect with like-minded individuals for advice, motivation, and support.
- **User-Friendly Interface**: Track your cycles, symptoms, and moods effortlessly with an intuitive interface.
- **Privacy & Security**: Your health data is secure, private, and protected.

---

### Future Enhancements

1. **Mobile App**: A mobile app to make FemCare more accessible on the go.
2. **AI-Powered Predictions**: Machine learning integration to improve cycle predictions and health recommendations.
3. **Health Device Integration**: Sync with wearable health devices for automatic symptom and health data tracking.
4. **Multi-Language Support**: Expand the platform to a global audience with support for multiple languages.
5. **Advanced Analytics**: Offer deeper insights with advanced analytics and detailed health reports.

---

### Conclusion

FemCare is an all-in-one menstrual health tracking platform that empowers women to take control of their health. With features for cycle tracking, symptom monitoring, mood logging, and community support, FemCare makes it easy to understand and manage menstrual health. Built with security, usability, and privacy in mind, FemCare is a valuable tool for women everywhere.

Whether you’re tracking your cycles, engaging with the community, or simply learning more about your body, FemCare is here to support you!

---

### Get Involved!

**Open Source**: FemCare is open-source and can be customized and extended by developers. Contribute to the project on [GitHub](https://github.com/HirushaDilshanOfficial/women_Period_Tracker).
