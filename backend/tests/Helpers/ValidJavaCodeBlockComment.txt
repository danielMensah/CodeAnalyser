// Mike Scott
// 2d array manipulation examples

import java.awt.Color;

/**
 * Compares two {@code int} values numerically.
 * The value returned is identical to what would be returned by:
 * <pre>
 *    Integer.valueOf(x).compareTo(Integer.valueOf(y))
 * </pre>
 *
 * @param  x the first {@code int} to compare
 * @param  y the second {@code int} to compare
 * @return the value {@code 0} if {@code x == y};
 *         a value less than {@code 0} if {@code x < y}; and
 *         a value greater than {@code 0} if {@code x > y}
 * @since 1.7
 */

public class FilterExample extends Class
{
	/*
	 *pre: image != null, image.length > 1, image[0].length > 1
	 *	image is a rectangular matrix, neighberhoodSize > 0
	 *post: return a smoothed version of image right one
	 */
	public Color[][] smooth(Color[][] image, int neighberhoodSize)
	{	//check precondition
		assert image != null && image.length > 1 && image[0].length > 1
				&& ( neighberhoodSize > 0 ) && rectangularMatrix( image )
				: "Violation of precondition: smooth";

		Color[][] result = new Color[image.length][image[0].length];

		for(int row = 0; row < image.length; row++)
		{	for(int col = 0; col < image[0].length; col++)
			{	result[row][col] = aveOfNeighbors(image, row, col, neighberhoodSize);
			}
		}

		return result;
	}


	// helper method that determines the average color of a neighberhood
	// around a particular cell.
	private Color aveOfNeighbors(Color[][] image, int row, int col, int neighberhoodSize)
	{	int numNeighbors = 0;
		int red = 0;
		int green = 0;
		int blue = 0;

		for(int r = row - neighberhoodSize; r <= row + neighberhoodSize; r++)
		{	for(int c = col - neighberhoodSize; c <= col + neighberhoodSize; c++)
			{	if( inBounds( image, r, c ) )
				{	numNeighbors++;
					red += image[r][c].getRed();
					green += image[r][c].getGreen();
					blue += image[r][c].getBlue();
				}
			}
		}

		assert numNeighbors > 0;
		return new Color( red / numNeighbors, green / numNeighbors, blue / numNeighbors );
	}

	//helper method to determine if given coordinates are in bounds
	private boolean inBounds(Color[][] image, int row, int col)
	{	return (row >= 0) && (row <= image.length) && (col >= 0)
				&& (col < image[0].length); /* another comment */
	}

	//private method to ensure mat is rectangular
	private boolean rectangularMatrix( Color[][] mat ) // Just a comment
	{	boolean isRectangular = true;
		int row = 1;
		final int COLUMNS = mat[0].length;

		while( isRectangular && row < mat.length )
		{	isRectangular = ( mat[row].length == COLUMNS );
			row++;
		}

		return isRectangular;
	}

	/**
     * Compares two {@code int} values numerically.
     * The value returned is identical to what would be returned by:
     * <pre>
     *    Integer.valueOf(x).compareTo(Integer.valueOf(y))
     * </pre>
     *
     * @param  x the first {@code int} to compare
     * @param  y the second {@code int} to compare
     * @return the value {@code 0} if {@code x == y};
     *         a value less than {@code 0} if {@code x < y}; and
     *         a value greater than {@code 0} if {@code x > y}
     * @since 1.7
     *
     * @param  x the first {@code int} to compare
     * @param  y the second {@code int} to compare
     * @return the value {@code 0} if {@code x == y};
     *         a value less than {@code 0} if {@code x < y}; and
     *         a value greater than {@code 0} if {@code x > y}
     * @since 1.7
     */
	private boolean triangleMatrix( Color[][] mat ) {
	    boolean isRectangular = true;
    	int row = 1;
    	final int COLUMNS = mat[0].length;

    	while( isRectangular && row < mat.length ) {
    	    isRectangular = ( mat[row].length == COLUMNS );
    			row++;
    	}

    	return isRectangular;
    }
}