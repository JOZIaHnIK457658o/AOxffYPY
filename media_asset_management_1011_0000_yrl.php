<?php
// 代码生成时间: 2025-10-11 00:00:44
class MediaAssetManager {

    // Database connection
    protected \$db;

    /**
     * Constructor
     *
     * @param PDO \$db Database connection
     */
    public function __construct(\$db) {
        $this->db = \$db;
    }

    /**
     * Add a new media asset
     *
     * @param string \$name Asset name
     * @param string \$description Asset description
     * @param string \$type Asset type (e.g., image, video, audio)
     *
     * @return int The ID of the newly added asset
     * @throws Exception If the database operation fails
     */
    public function addAsset(\$name, \$description, \$type) {
        try {
            \$stmt = \$this->db->prepare("INSERT INTO media_assets (name, description, type) VALUES (:name, :description, :type)");
            \$stmt->bindParam(':name', \$name);
            \$stmt->bindParam(':description', \$description);
            \$stmt->bindParam(':type', \$type);
            \$stmt->execute();

            return \$this->db->lastInsertId();
        } catch (PDOException \$e) {
            throw new Exception("Failed to add media asset: " . \$e->getMessage());
        }
    }

    /**
     * Update an existing media asset
     *
     * @param int \$id Asset ID
     * @param string \$name Asset name
     * @param string \$description Asset description
     * @param string \$type Asset type
     *
     * @return bool True on success, false on failure
     * @throws Exception If the database operation fails
     */
    public function updateAsset(\$id, \$name, \$description, \$type) {
        try {
            \$stmt = \$this->db->prepare("UPDATE media_assets SET name = :name, description = :description, type = :type WHERE id = :id");
            \$stmt->bindParam(':id', \$id);
            \$stmt->bindParam(':name', \$name);
            \$stmt->bindParam(':description', \$description);
            \$stmt->bindParam(':type', \$type);
            \$stmt->execute();

            return \$stmt->rowCount() > 0;
        } catch (PDOException \$e) {
            throw new Exception("Failed to update media asset: " . \$e->getMessage());
        }
    }

    /**
     * Delete a media asset
     *
     * @param int \$id Asset ID
     *
     * @return bool True on success, false on failure
     * @throws Exception If the database operation fails
     */
    public function deleteAsset(\$id) {
        try {
            \$stmt = \$this->db->prepare("DELETE FROM media_assets WHERE id = :id");
            \$stmt->bindParam(':id', \$id);
            \$stmt->execute();

            return \$stmt->rowCount() > 0;
        } catch (PDOException \$e) {
            throw new Exception("Failed to delete media asset: " . \$e->getMessage());
        }
    }

    /**
     * Retrieve a media asset by ID
     *
     * @param int \$id Asset ID
     *
     * @return array|null The asset data or null if not found
     * @throws Exception If the database operation fails
     */
    public function getAssetById(\$id) {
        try {
            \$stmt = \$this->db->prepare("SELECT * FROM media_assets WHERE id = :id");
            \$stmt->bindParam(':id', \$id);
            \$stmt->execute();

            \$result = \$stmt->fetch(PDO::FETCH_ASSOC);
            return \$result ?: null;
        } catch (PDOException \$e) {
            throw new Exception("Failed to retrieve media asset: " . \$e->getMessage());
        }
    }

    /**
     * Retrieve all media assets
     *
     * @return array List of all assets
     * @throws Exception If the database operation fails
     */
    public function getAllAssets() {
        try {
            \$stmt = \$this->db->query("SELECT * FROM media_assets");

            return \$stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException \$e) {
            throw new Exception("Failed to retrieve all media assets: " . \$e->getMessage());
        }
    }
}

// Usage example
try {
    \$db = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
    \$manager = new MediaAssetManager(\$db);

    \$assetId = \$manager->addAsset("Example Asset", "This is an example asset.", "image");
    echo "Asset added with ID: \$assetId\
";

    \$manager->updateAsset(\$assetId, "Updated Asset", "This asset has been updated.", "image");
    echo "Asset updated successfully.\
";

    \$asset = \$manager->getAssetById(\$assetId);
    echo "Retrieved asset: ";
    print_r(\$asset);

    \$manager->deleteAsset(\$assetId);
    echo "Asset deleted successfully.\
";

    \$allAssets = \$manager->getAllAssets();
    echo "All assets: ";
    print_r(\$allAssets);
} catch (Exception \$e) {
    echo "Error: " . \$e->getMessage();
}
