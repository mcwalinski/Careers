<?php
/*YTo3OntzOjMyOiJiM2E2NWE5YzE4NzZjZDMwOGJiOWU2NThkZDEyOWM2MSI7YToxOntpOjA7Tzo4OiJzdGRDbGFzcyI6MTA6e3M6NzoidGVybV9pZCI7czoyOiI1NCI7czo0OiJuYW1lIjtzOjQ6IkhvbWUiO3M6NDoic2x1ZyI7czo0OiJob21lIjtzOjEwOiJ0ZXJtX2dyb3VwIjtzOjE6IjAiO3M6MTA6InRlcm1fb3JkZXIiO3M6MToiMCI7czoxNjoidGVybV90YXhvbm9teV9pZCI7czoyOiI1NCI7czo4OiJ0YXhvbm9teSI7czo4OiJjYXRlZ29yeSI7czoxMToiZGVzY3JpcHRpb24iO3M6MDoiIjtzOjY6InBhcmVudCI7czoxOiIwIjtzOjU6ImNvdW50IjtpOjE7fX1zOjMyOiJiZWJmMmQwNTkyMWYwNjJhMzhiOWZlY2VhNjQzY2ZhNSI7YToxOntpOjA7Tzo4OiJzdGRDbGFzcyI6MTA6e3M6NzoidGVybV9pZCI7czoxOiI1IjtzOjQ6Im5hbWUiO3M6MTA6IkNvbnRhY3QgVXMiO3M6NDoic2x1ZyI7czo5OiJjb250YWN0dXMiO3M6MTA6InRlcm1fZ3JvdXAiO3M6MToiMCI7czoxMDoidGVybV9vcmRlciI7czoyOiIxNCI7czoxNjoidGVybV90YXhvbm9teV9pZCI7czoxOiI1IjtzOjg6InRheG9ub215IjtzOjg6ImNhdGVnb3J5IjtzOjExOiJkZXNjcmlwdGlvbiI7czoyNjoiY2F0ZWdvcnkvdHdvQ29sdW1uUG9zdC5waHAiO3M6NjoicGFyZW50IjtzOjE6IjAiO3M6NToiY291bnQiO2k6MTt9fXM6MzI6Ijk0NWJkMmYwZmU4MTIwZDI0ZGQzYTRlZDE4ZDU1N2ExIjthOjE6e2k6MDtPOjg6InN0ZENsYXNzIjoxMDp7czo3OiJ0ZXJtX2lkIjtzOjE6IjQiO3M6NDoibmFtZSI7czoxMzoiQ2FyZWVyIENlbnRlciI7czo0OiJzbHVnIjtzOjEyOiJjYXJlZXJjZW50ZXIiO3M6MTA6InRlcm1fZ3JvdXAiO3M6MToiMCI7czoxMDoidGVybV9vcmRlciI7czoxOiI2IjtzOjE2OiJ0ZXJtX3RheG9ub215X2lkIjtzOjE6IjQiO3M6ODoidGF4b25vbXkiO3M6ODoiY2F0ZWdvcnkiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjI2OiJjYXRlZ29yeS9vbmVDb2x1bW5Qb3N0LnBocCI7czo2OiJwYXJlbnQiO3M6MToiMCI7czo1OiJjb3VudCI7aToxO319czozMjoiYTA0NjZmZjdjZTY3ZjA3Nzc0NjhhZmMxMjljNmQ0NmEiO2E6MTp7aTowO086ODoic3RkQ2xhc3MiOjEwOntzOjc6InRlcm1faWQiO3M6MjoiMzEiO3M6NDoibmFtZSI7czoxMDoiUHJvZHVjdGlvbiI7czo0OiJzbHVnIjtzOjEwOiJwcm9kdWN0aW9uIjtzOjEwOiJ0ZXJtX2dyb3VwIjtzOjE6IjAiO3M6MTA6InRlcm1fb3JkZXIiO3M6MToiMyI7czoxNjoidGVybV90YXhvbm9teV9pZCI7czoyOiIzMSI7czo4OiJ0YXhvbm9teSI7czo4OiJjYXRlZ29yeSI7czoxMToiZGVzY3JpcHRpb24iO3M6MjY6ImNhdGVnb3J5L3R3b0NvbHVtblBvc3QucGhwIjtzOjY6InBhcmVudCI7aTowO3M6NToiY291bnQiO2k6MTt9fXM6MzI6IjE4YzJmYWI0NWQ2ZjliMTZmZGIzMzJlNGIzNzcyNWNmIjthOjE6e2k6MDtPOjg6InN0ZENsYXNzIjoxMDp7czo3OiJ0ZXJtX2lkIjtzOjI6Ijg5IjtzOjQ6Im5hbWUiO3M6MjA6IlNlYXJjaCBPcHBvcnR1bml0aWVzIjtzOjQ6InNsdWciO3M6MTQ6InNlYXJjaG9wZW5pbmdzIjtzOjEwOiJ0ZXJtX2dyb3VwIjtzOjE6IjAiO3M6MTA6InRlcm1fb3JkZXIiO3M6MToiMSI7czoxNjoidGVybV90YXhvbm9teV9pZCI7czoyOiI4OSI7czo4OiJ0YXhvbm9teSI7czo4OiJjYXRlZ29yeSI7czoxMToiZGVzY3JpcHRpb24iO3M6MjY6ImNhdGVnb3J5L29uZUNvbHVtblBvc3QucGhwIjtzOjY6InBhcmVudCI7czoxOiIwIjtzOjU6ImNvdW50IjtpOjE7fX1zOjMyOiJkMzkwNTRjMzg5ZDQxZTk4YjdiZjdlZDEwNGViNzM2NSI7YToxOntpOjA7Tzo4OiJzdGRDbGFzcyI6MTA6e3M6NzoidGVybV9pZCI7czoyOiI5NiI7czo0OiJuYW1lIjtzOjE5OiJUaGUgV2FzaGluZ3RvbiBQb3N0IjtzOjQ6InNsdWciO3M6MjQ6Indhc2hwb3N0am9ib3Bwb3J0dW5pdGllcyI7czoxMDoidGVybV9ncm91cCI7czoxOiIwIjtzOjEwOiJ0ZXJtX29yZGVyIjtzOjE6IjAiO3M6MTY6InRlcm1fdGF4b25vbXlfaWQiO3M6MjoiOTYiO3M6ODoidGF4b25vbXkiO3M6ODoiY2F0ZWdvcnkiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjI2OiJjYXRlZ29yeS9vbmVDb2x1bW5Qb3N0LnBocCI7czo2OiJwYXJlbnQiO2k6MDtzOjU6ImNvdW50IjtpOjE7fX1zOjMyOiJkMWUyNDhhMjUxODMwYTU4YzdjOTQ0NTc5YmIyZTM0YSI7YToxOntpOjA7Tzo4OiJzdGRDbGFzcyI6MTA6e3M6NzoidGVybV9pZCI7czoyOiIzNyI7czo0OiJuYW1lIjtzOjk6IkVtcGxveWVlcyI7czo0OiJzbHVnIjtzOjE2OiJlbXBsb3llZXByb2ZpbGVzIjtzOjEwOiJ0ZXJtX2dyb3VwIjtzOjE6IjAiO3M6MTA6InRlcm1fb3JkZXIiO3M6MToiMCI7czoxNjoidGVybV90YXhvbm9teV9pZCI7czoyOiIzNyI7czo4OiJ0YXhvbm9teSI7czo4OiJjYXRlZ29yeSI7czoxMToiZGVzY3JpcHRpb24iO3M6MzM6ImNhdGVnb3J5L29uZUNvbHVtblByb2ZpbGVMaXN0LnBocCI7czo2OiJwYXJlbnQiO2k6MDtzOjU6ImNvdW50IjtpOjE7fX19*/
?>