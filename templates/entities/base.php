<?PHP
include_once "../config/dbclass.php";
class %s {
	private $connection;

	private $query;
	private $table_name = "%s";

	public $id;
%s

	public function __construct($connection) {
		$this->connection = $connection;
	}

	private function execute() {
		$stmt = $this->connection->prepare($this->query);
		$stmt->execute();
		return $stmt;
	}

	public function create() {
		$this->query = "INSERT INTO " . $this->table_name . " (%s) VALUES(" . %s ");";
		return $this->execute();
	}

	public function read() {
		if ($this->id > 0) {
			$this->query = "SELECT * FROM " . $this->table_name . " WHERE id=" . $this->id . ";";
		} else {
			$this->query = "SELECT * FROM " . $this->table_name . ";";
		}
		return $this->execute();
	}
	
	public function update() {
		if ($this->id > 0) {
			$stmt = $this->read();
			$count = $stmt->rowCount();
			if ($count > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				extract($row);
%s

				$this->query = "UPDATE " . $this->table_name . " SET " . %s . " WHERE id=" . $this->id . ";";
				
				return $this->execute();
			}
			return NULL;
		}
		return NULL;
	}

	public function delete() {
		if ($this->id > 0) {
			$this->query = "DELETE FROM " . $this->table_name . " WHERE id=" . $this->id . ";";
			return $this->execute();
		}
		return NULL;
	}
}
?>
