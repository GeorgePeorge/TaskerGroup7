package uk.ac.aber.cs221.group_7.util.TaskerCli;
/**
 * A task has a status, it can either be ALLOCATED, COMPLETED or ABANDONED
 * 
 * @author Group 07: kuh1@aber.ac.uk
 * @version 1.0
 * @date 29/01/2015
 */
public enum Status {
	ALLOCATED, COMPLETED, ABANDONED; 
	
	/**
	 * Converts the given string to a status if it is valid
	 * @param string
	 * 			The input string, should be spelt exactly like the desred enum to match
	 * @return
	 * 			The status
	 */
	public static Status stringToStatus(String string){
		Status status = null;
		
		if(string.toUpperCase().equals("ALLOCATED")){
			status = Status.ALLOCATED;
		}else if(string.toUpperCase().equals("COMPLETED")){
			status = Status.COMPLETED;
		}else if(string.toUpperCase().equals("ABANDONED")){
			status = Status.ABANDONED;
		}
		
		return status;
	}
	
	
	/**
	 * Returns the enum as a lower case string
	 */
	@Override
	public String toString() {
		return this.name().toLowerCase();
	}
}
