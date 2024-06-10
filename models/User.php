<?php

/**
 * User - Manage CURD function of table users
 */
class User {

  /**
   * Create User instance
   * 
   * @param int | null $id the user id
   * @param string $first_name the user first name
   * @param string $last_name the user last name
   * @param string $gender the user gender
   * @param string $birth_date the user birth date
   * @param string $username the user username
   * @param string $password the user password
   */
  public function __construct(
    public int | null $id,
    public string $first_name,
    public string $last_name,
    public string $gender,
    public string $birth_date,
    public string $username,
    public string $password,
  ) {}
  
  /**
   * Create User instance from array
   *
   * @param array $data the user array data
   * @return User the user instance
   */
  static function fromArray(array $data): User {
    return new User(
      $data['id'],
      $data['first_name'],
      $data['last_name'],
      $data['gender'],
      $data['birth_date'],
      $data['username'],
      $data['password'],
    );
  }

  /**
   * Create array of User instance from array of arrays
   *
   * @param array $items the array of arrays
   * @return User[] the array of User instances
   */
  static function allFromArray(array $items): array {
    $Users = [];

    foreach($items as $item) 
      $Users[] = User::fromArray($item);

    return $Users;
  }
  
  /**
   * Insert the User instance to users table
   *
   * @param PDO $pdo the pdo connection
   * @param User $User the User instance
   * @return int | null the inserted user id if success or null
   */
  static function create(PDO $pdo, User $User): int | null {
    $query = "INSERT INTO `users` (`first_name`, `last_name`, `gender`, `birth_date`, `username`, `password`) VALUES (?, ?, ?, ?, ?, ?)";

    $prep = $pdo->prepare($query);

    if ($prep->execute([
      $User->first_name,
      $User->last_name,
      $User->gender,
      $User->birth_date,
      $User->username,
      hash('md5', $User->password),
    ])) return $pdo->lastInsertId();
    
    return null;
  }

  /**
   * Update the user row with the new user details
   *
   * @param PDO $con the pdo connection
   * @return boolean true if success otherwise false
   */
  function update(PDO $con): bool {
    $query = "UPDATE `users` SET `first_name` = ?, `last_name` = ?, `gender` = ?, `birth_date` = ?, `username` = ?, `password` = ? WHERE `id` = ?";

    return $con->prepare($query)->execute([
      $this->first_name,
      $this->last_name,
      $this->gender,
      $this->birth_date,
      $this->password,
      hash('md5', $this->username),
      $this->id,
    ]);
  }

  /**
   * Find the user row from find and find by column and convert it to User instance from id
   *
   * @param PDO $pdo the pdo connection
   * @param mixed $find the find value
   * @param string $findBy the column name
   * @return User | null the User instance if is exists or null of not
   */
  static function find(PDO $pdo, mixed $find, string $findBy = 'id'): User | null {
    $query = "SELECT * FROM `users` WHERE `$findBy` = :find";

    $prep = $pdo->prepare($query);
    $prep->bindParam(':find', $find, PDO::PARAM_STR);
    $prep->execute();

    $collection = $prep->fetch(PDO::FETCH_ASSOC);

    if ($collection)
      return User::fromArray($collection);

    return null;
  }

  /**
   * Get the User instances by where query
   * 
   * @param PDO $pdo the pdo connection
   * @param string | array | null $where the where query if is string or array of where items or null
   * @param string $whereMerge the merge type of where items (OR, AND)
   * @param string | null $orderBy the order by column
   * @param string $orderType the order type (ASC, DESC)
   * @return User[] the array of User instances
   */
  static function where(PDO $pdo, string | array | null $where = null, string $whereMerge = 'AND', string | null $orderBy = null, string $orderType = "ASC") {
    $query = "SELECT * FROM `users`";

    if ($where && is_string($where))
      $query .= $where;
    else if ($where && is_array($where)) {
      $query .= "WHERE ";
      $items = [];

      foreach($where as $item)
        $items[] =  "{$item[0]} {$item[1]} {$item[2]}";
      
      $query .= implode(" $whereMerge ", $items);
    }

    if ($orderBy)
      $query .= " ORDER BY `$orderBy` $orderType";

    $collection =  $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

    return User::allFromArray($collection);
  }

  /**
   * Get all User instances
   * 
   * @param PDO $pdo the pdo connection
   * @param string | null $orderBy the order by column
   * @param string $orderType the order type (ASC, DESC)
   * @return User[] the array of User instances
   */
  static function all(PDO $pdo, string | null $orderBy = null, string $orderType = "ASC") {
    return User::where($pdo, null, 'AND', $orderBy, $orderType);
  }

  /**
   * Search for users by search text
   * 
   * @param PDO $pdo the pdo connection
   * @param string $text the search text
   * @param string | null $orderBy the order by column
   * @param string $orderType the order type (ASC, DESC)
   * @return User[] the array of User instances
   */
  static function search(PDO $pdo, string $text, string | null $orderBy = null, string $orderType = "ASC") {
    return User::where($pdo, [
      ['`first_name`', 'LIKE', "'%$text%'"],
      ['`last_name`', 'LIKE', "'%$text%'"],
      ['`gender`', 'LIKE', "'%$text%'"],
      ['`birth_date`', 'LIKE', "'%$text%'"],
      ['`username`', 'LIKE', "'%$text%'"],
    ], 'OR', $orderBy, $orderType);
  }

  /**
   * Remove the user from table by id
   *
   * @param PDO $pdo
   * @param integer $id the user id
   * @return boolean true if success otherwise false
   */
  static function remove(PDO $pdo, int $id): bool {
    $query = "DELETE FROM `users` WHERE `id` = :id";
    
    $prep = $pdo->prepare($query);
    $prep->bindParam(':id', $id, PDO::PARAM_STR);
    return $prep->execute();
  }

  /**
   * Delete this User from table by his id
   *
   * @param PDO $pdo
   * @return boolean true if success otherwise false
   */
  function delete(PDO $pdo) {
    return User::remove($pdo, $this->id);
  } 

}

## karmer_7171@gmail.com