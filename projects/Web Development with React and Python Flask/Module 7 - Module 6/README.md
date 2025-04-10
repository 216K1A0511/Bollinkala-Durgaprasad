
// Full example of a user profile component
interface UserProfileProps {
  userId: number;
}

const UserProfile: React.FC<UserProfileProps> = ({ userId }) => {
  const [user, setUser] = useState<User | null>(null);
  const [tests, setTests] = useState<SpeakingTest[]>([]);
  const [loading, setLoading] = useState({
    user: false,
    tests: false,
  });
  const [error, setError] = useState({
    user: "",
    tests: "",
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading((prev) => ({ ...prev, user: true }));
        const userResponse = await axiosInstance.get<User>(`/users/${userId}`);
        setUser(userResponse.data);
      } catch (err) {
        setError((prev) => ({ ...prev, user: "Failed to load user" }));
      } finally {
        setLoading((prev) => ({ ...prev, user: false }));
      }

      try {
        setLoading((prev) => ({ ...prev, tests: true }));
        const testsResponse = await axiosInstance.get<SpeakingTest[]>(
          `/users/${userId}/tests`
        );
        setTests(testsResponse.data);
      } catch (err) {
        setError((prev) => ({ ...prev, tests: "Failed to load tests" }));
      } finally {
        setLoading((prev) => ({ ...prev, tests: false }));
      }
    };

    fetchData();
  }, [userId]);

  if (loading.user || loading.tests) return <div>Loading...</div>;

  return (
    <div>
      {user && (
        <div>
          <h2>{user.name}</h2>
          <p>Email: {user.email}</p>
          <p>Member since: {new Date(user.createdAt).toLocaleDateString()}</p>
        </div>
      )}
      {error.user && <div className="error">{error.user}</div>}

      <h3>Test Results</h3>
      {tests.length > 0 ? (
        <ul>
          {tests.map((test) => (
            <li key={test.id}>
              {test.question} - Score: {test.score}
            </li>
          ))}
        </ul>
      ) : (
        <p>No tests taken yet</p>
      )}
      {error.tests && <div className="error">{error.tests}</div>}
    </div>
  );
};
