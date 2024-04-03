<?php

namespace silverorange\DevTest\Model;

class Post
{
    public string $id;
    public string $title;
    public string $body;
    public string $created_at;
    public string $modified_at;
    public string $author;
    public array $record = [];
    protected \PDO $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
    public function getAllPosts()
    {
        try {
            // Prepare SQL statement
            $sql = "SELECT posts.*, authors.full_name FROM posts
                   LEFT JOIN authors ON posts.author = authors.id
                   ORDER BY posts.created_at DESC; ";
            $stmt = $this->db->query($sql);
            // Fetch all posts as associative array
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getPostByID($id)
    {
        try {
            // Prepare SQL statement
            $sql = "SELECT posts.*, authors.full_name FROM posts
                   LEFT JOIN authors ON posts.author = authors.id
                   WHERE posts.id = '" . $id . "' ; ";

            $stmt = $this->db->query($sql);
            // Fetch all posts as associative array
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function importPosts($jsonData)
    {
        try {
            $data = $jsonData;
            $sqlToCheckAuthor = "SELECT COUNT(*) FROM authors where id = '" . $data['author'] . "'";
            $stmtToCheckAuthor = $this->db->query($sqlToCheckAuthor);
            // Fetch all posts as associative array
            $authorExist = $stmtToCheckAuthor->fetchAll(\PDO::FETCH_ASSOC)[0]['count'];
            if ($authorExist > 0) {
                // Prepare SQL statement
                $columns = " (id, title, body, created_at, modified_at, author) ";
                $values =  "(:id, :title, :body, :created_at, :modified_at, :author)";
                $sql = "INSERT INTO posts " . $columns . " VALUES " . $values;
                $stmt = $this->db->prepare($sql);
                // Bind parameters
                $stmt->bindParam(':id', $data['id'], \PDO::PARAM_STR);
                $stmt->bindParam(':title', $data['title']);
                $stmt->bindParam(':body', $data['body']);
                $stmt->bindParam(':created_at', $data['created_at']);
                $stmt->bindParam(':modified_at', $data['modified_at']);
                $stmt->bindParam(':author', $data['author']);
                // Execute the statement
                if ($stmt->execute()) {
                    $record['id'] = $data['id'];
                    $record['success'] = 'true';
                    $record['message'] = 'Data imported successfully';
                } else {
                    $record['id'] = $data['id'];
                    $record['success'] = 'false';
                    $record['message'] = 'something went wrong! Record data is not correct';
                }
            } else {
                $record['id'] = $data['id'];
                $record['success'] = 'false';
                $record['message'] = 'Author does not exist';
            }
            return $record;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
