<?PHP
include_once "../config/dbclass.php";
class Todo {
	private $connection;

	private $query;
	private $table_name = "todo";

	public $id;
	public $percent_done;
	public $text;
	public $category_id;


	public function __construct($connection) {
		$this->connection = $connection;
	}

	private function execute() {
		$stmt = $this->connection->prepare($this->query);
		$stmt->execute();
		return $stmt;
	}

	public function create() {
		$this->query = "INSERT INTO " . $this->table_name . " (percent_done, text, category_id) VALUES(" . "" . $this->percent_done . ", " . "'" . addslashes($this->text) . "', " . "" . $this->category_id . "" .  ");";
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
				if (!$this->percent_done) {
					$this->percent_done = $percent_done;
				}
				if (!$this->text) {
					$this->text = $text;
				}
				if (!$this->category_id) {
					$this->category_id = $category_id;
				}


				$this->query = "UPDATE " . $this->table_name . " SET " . "percent_done=" . $this->percent_done . ", " . "text='" . addslashes($this->text) . "', " . "category_id=" . $this->category_id . "" . " WHERE id=" . $this->id . ";";
				
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
