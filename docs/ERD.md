# Entity relationship diagram

The four domain entities and their relationships:

```mermaid
erDiagram
    USERS ||--o| ATHLETES : has
    USERS ||--o{ TRAINING_SESSIONS : creates
    USERS ||--o{ TRAINING_SESSIONS : reviews
    ATHLETES ||--o{ TRAINING_SESSIONS : schedules
    TRAINING_TYPES ||--o{ TRAINING_SESSIONS : categorizes
    USERS {
      bigint id PK
      string name
      string email UK
      string password
      enum role
    }
    ATHLETES {
      bigint id PK
      bigint user_id FK,UK
      string athlete_id_number UK
      string first_name
      string last_name
      date birthdate
      string sport
    }
    TRAINING_TYPES {
      bigint id PK
      string name UK
      text description
      boolean is_active
    }
    TRAINING_SESSIONS {
      bigint id PK
      bigint athlete_id FK
      bigint training_type_id FK
      bigint created_by FK
      bigint reviewed_by FK
      date session_date
      enum status
      smallint duration_minutes
      tinyint perceived_exertion
      decimal distance_km
      text athlete_notes
      text coach_feedback
    }
```

Export this Mermaid diagram as an image for the final report/slides.

Sanctum stores API bearer tokens in its framework `personal_access_tokens` table, which is an authentication infrastructure table in addition to the four domain tables.
