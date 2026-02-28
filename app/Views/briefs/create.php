<!-- 
  TEAM: This is Moataz's "Brief Creation" page. 
  I've used Bootstrap to give it that "Guerrilla Marketing Agency" look.
  NOTE: I added 'enctype="multipart/form-data"' because otherwise, 
  images won't physically leave the user's computer! 
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/Ad-Attack/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-warning mb-4">📢 Post a New Creative Brief</h2>
            
            <form action="/brief/store" method="POST" enctype="multipart/form-data" class="card bg-secondary p-4 shadow">
                
                <div class="mb-3">
                    <label class="form-label">Challenge Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Sell this 1990s Brick Phone" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (The Mission)</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Tell the creatives what the goal is..." required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="Tech">Tech</option>
                            <option value="Food">Food</option>
                            <option value="Absurd">Absurd/Funny</option>
                            <option value="Luxury">Luxury</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">The "Ugly" Product Photo</label>
                    <input type="file" name="brief_image" class="form-control" accept="image/*" required>
                    <div class="form-text text-light">Upload the original photo for creatives to edit.</div>
                </div>

                <button type="submit" class="btn btn-warning fw-bold w-100">LAUNCH CHALLENGE 🚀</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>