$sqlShowAll= "SELECT Person.PersonID AS 'PersonID', Person.FirstName AS 'FN', Person.MiddleInitial AS 'MI',
           Person.LastName AS 'LN', VolunteerDepartment.DepartmentID AS 'Dept', Shift.StartTime AS 'Arrived'
    FROM Person
      JOIN Volunteer ON Person.PersonID = Volunteer.PersonID
      JOIN VolunteerDepartment ON Volunteer.VolunteerID = VolunteerDepartment.VolunteerID
      JOIN Shift ON VolunteerDepartment.VolunteerID = Shift.VolunteerID
    WHERE Shift.CheckedIn = 'y'
    ORDER BY Person.LastName;";