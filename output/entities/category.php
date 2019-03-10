<?PHP
include_once "../config/dbclass.php";
class Category {
	private $connection;

	private $query;
	private $table_name = "category";

	public $id;
	public $name;


	public function __construct($connection) {
		$this->connection = $connection;
	}

	private function execute() {
		$stmt = $this->connection->prepare($this->query);
		$stmt->execute();
		return $stmt;
	}

	public function create() {
		$this->query = "INSERT INTO " . $this->table_name . " (name) VALUES(" . "'" . addslashes($this->name) . "'" .  ");";
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
				if (!$this->name) {
					$this->name = $name;
				}


				$this->query = "UPDATE " . $this->table_name . " SET " . "name='" . addslashes($this->name) . "'" . " WHERE id=" . $this->id . ";";
				
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
