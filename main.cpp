#include <mysql_driver.h>
#include <mysql_connection.h>
#include <cppconn/prepared_statement.h>
#include <iostream>
#include <string>
#include <sstream>

void insertStudent(const std::string& name, int attendance, int unitTest, const std::string& achievements, int mockPractical) {
    double termWork = (attendance * 0.1) + (unitTest * 0.3) + (mockPractical * 0.6);

    sql::mysql::MySQL_Driver* driver;
    sql::Connection* con;
    sql::PreparedStatement* pstmt;

    driver = sql::mysql::get_mysql_driver_instance();
    con = driver->connect("tcp://127.0.0.1:3306", "root", "");
    con->setSchema("student_assessment");

    pstmt = con->prepareStatement(
        "INSERT INTO students (name, attendance, unit_test_score, achievements, mock_practical_score, term_work) VALUES (?, ?, ?, ?, ?, ?)"
    );
    pstmt->setString(1, name);
    pstmt->setInt(2, attendance);
    pstmt->setInt(3, unitTest);
    pstmt->setString(4, achievements);
    pstmt->setInt(5, mockPractical);
    pstmt->setDouble(6, termWork);
    pstmt->executeUpdate();

    delete pstmt;
    delete con;
}

int main(int argc, char* argv[]) {
    if (argc < 6) {
        std::cerr << "Invalid number of arguments. Required: name, attendance, unitTest, achievements, mockPractical" << std::endl;
        return 1;
    }

    std::string name = argv[1];
    int attendance = std::stoi(argv[2]);
    int unitTest = std::stoi(argv[3]);

    std::ostringstream achievementsStream;
    for (int i = 4; i < argc - 1; ++i) {
        achievementsStream << argv[i];
        if (i < argc - 2) achievementsStream << " ";
    }
    std::string achievements = achievementsStream.str();

    int mockPractical = std::stoi(argv[argc - 1]);

    try {
        insertStudent(name, attendance, unitTest, achievements, mockPractical);
        std::cout << "Record added successfully!" << std::endl;
    } catch (const std::exception& e) {
        std::cerr << "Error inserting record: " << e.what() << std::endl;
    }

    return 0;
}
